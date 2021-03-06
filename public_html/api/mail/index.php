<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;

try {
	//grab the mailgun configuration
	$mailgunConfig = json_decode($_ENV["MAILGUN"]);
	$recaptchaConfig = json_decode($_ENV["RECAPTCHA"]);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// handle GET request - just kick them out
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		header("Location: ../..", true, 301);
	} else if($method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// verify recaptcha
		$recaptchaErrorMessage = "unable to send email: incorrect captcha";
		if(empty($requestObject->recaptcha) === true) {
			throw(new RuntimeException($recaptchaErrorMessage, 403));
		}
		$recaptcha = new \ReCaptcha\ReCaptcha($recaptchaConfig->secretKey);
		$recaptchaResult = $recaptcha->verify($requestObject->recaptcha, $_SERVER["REMOTE_ADDR"]);
		if($recaptchaResult->isSuccess() === false) {
			throw(new RuntimeException($recaptchaErrorMessage, 403));
		}

		// sanitize inputs
		$name = filter_var($requestObject->contactName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$email = filter_var($requestObject->contactEmail, FILTER_SANITIZE_EMAIL);
		$subject = filter_var($requestObject->contactSubject, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$message = filter_var($requestObject->contactMessage, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// throw out blank fields
		if(empty($name) === true) {
			throw(new InvalidArgumentException("name is required", 400));
		}
		if(empty($email) === true) {
			throw(new InvalidArgumentException("email is required", 400));
		}
		if(empty($subject) === true) {
			throw(new InvalidArgumentException("subject is required", 400));
		}
		if(empty($message) === true) {
			throw(new InvalidArgumentException("message is required", 400));
		}

		// start the mailgun client
		$mailgun = \Mailgun\Mailgun::create($mailgunConfig->apiKey);

		// send the message
		$mailgun->messages()->send($mailgunConfig->domain, [
				"from" => "$name <$email>",
				"to" => $mailgunConfig->recipient,
				"subject" => $subject,
				"text" => $message
			]
		);
		$reply->message = "Thank you for reaching out. I'll be in contact shortly!";
	}  else {
		throw(new InvalidArgumentException("Invalid HTTP method request", 405));
	}

	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);
