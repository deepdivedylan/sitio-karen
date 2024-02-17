<?php
require_once(dirname(__DIR__, 4) . '/vendor/autoload.php');
require_once(dirname(__DIR__, 3) . '/php/xsrf.php');

use Dotenv\Dotenv;
use Mailgun\Mailgun;
use ReCaptcha\ReCaptcha;
use ReCaptcha\RequestMethod\CurlPost;

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;

try {
    // load private data
    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 4));
    $dotenv->load();

    //determine which HTTP method was used
    $method = array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER) ? $_SERVER['HTTP_X_HTTP_METHOD'] : $_SERVER['REQUEST_METHOD'];

    // handle GET request - just kick them out
    if ($method === 'GET') {
        //set XSRF cookie
        setXsrfCookie();
        header('Location: /', true, 301);
    } else if ($method === 'POST') {
        verifyXsrf();
        $requestContent = file_get_contents('php://input');
        $requestObject = json_decode($requestContent);

        // verify recaptcha
        $recaptchaErrorMessage = 'unable to send email: incorrect captcha';
        if(empty($requestObject->recaptcha) === true) {
            throw(new RuntimeException($recaptchaErrorMessage, 403));
        }
        $recaptcha = new ReCaptcha($_ENV['RECAPTCHA_SECRET_KEY'], new CurlPost());
        $recaptchaResult = $recaptcha->setScoreThreshold(0.5)
            ->setExpectedAction('contact')
            ->verify($requestObject->recaptcha, $_SERVER['REMOTE_ADDR']);
        if ($recaptchaResult->isSuccess() === false) {
            throw(new RuntimeException($recaptchaErrorMessage, 403));
        }

        // sanitize inputs
        $htmlspecialchars_flags = ENT_NOQUOTES | ENT_SUBSTITUTE | ENT_HTML401;
        $name = htmlspecialchars($requestObject->name, $htmlspecialchars_flags);
        $email = filter_var($requestObject->email, FILTER_SANITIZE_EMAIL);
        $subject = htmlspecialchars($requestObject->subject, $htmlspecialchars_flags);
        $message = htmlspecialchars($requestObject->message, $htmlspecialchars_flags);

        // throw out blank fields
        if(empty($name) === true) {
            throw(new InvalidArgumentException('name is required', 400));
        }
        if(empty($email) === true) {
            throw(new InvalidArgumentException('email is required', 400));
        }
        if(empty($subject) === true) {
            throw(new InvalidArgumentException('subject is required', 400));
        }
        if(empty($message) === true) {
            throw(new InvalidArgumentException('message is required', 400));
        }

        // start the mailgun client
        $mailgun = Mailgun::create($_ENV['MAILGUN_SECRET_KEY']);

        // send the message
        $result = $mailgun->messages()->send($_ENV['MAILGUN_DOMAIN'], [
                'from' => $name . ' <' . $email . '>',
                'to' => $_ENV['MAILGUN_EMAIL'],
                'subject' => $subject,
                'text' => $message
            ]
        );
        $reply->message = 'Thank you for reaching out. I\'ll be in contact shortly!';
    }  else {
        throw(new InvalidArgumentException('Invalid HTTP method request', 405));
    }

    // update reply with exception information
} catch (Exception $exception) {
    $reply->status = $exception->getCode();
    $reply->message = $exception->getMessage();
} catch (TypeError $typeError) {
    $reply->status = $typeError->getCode();
    $reply->message = $typeError->getMessage();
}

// encode and return reply to front end caller
$httpStatusCode = $reply->status === 200 ? 200 : 500;
http_response_code($httpStatusCode);
header('Content-type: application/json');
echo json_encode($reply);
