<?php
require_once(dirname(__DIR__) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__) . "/php/intl/Translator.php");

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
setXsrfCookie();

if (empty($_SESSION["locale"]) === true) {
	$locale = Translator::getLocale();
	$_SESSION["locale"] = $locale;
	setcookie("locale", $locale, time() + 2592000); // 30 day cookie
} else {
	$locale = $_SESSION["locale"];
}
$translator = new Translator($locale);
$googleTagManager = $_ENV("GOOGLETAGMANAGER");
$recaptcha = json_decode($_ENV["RECAPTCHA"]);

$previewData = (object)[
	"description" => $translator->getTranslatedString("description"),
	"image" => "https://" . $_SERVER["HTTP_HOST"] . "/images/globe-preview.png",
	"title" => $translator->getTranslatedString("title"),
	"url" => "https://" . $_SERVER["HTTP_HOST"] . "/",
];
?>
<!DOCTYPE html>
<html lang="<?php echo $locale;?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<title><?php echo $translator->getTranslatedString("title"); ?></title>

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','<?php echo $googleTagManager; ?>');</script>
        <!-- End Google Tag Manager -->

		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo $previewData->url; ?>" />
		<meta property="og:title" content="<?php echo $previewData->title; ?>" />
		<meta property="og:description" content="<?php echo $previewData->description; ?>" />
		<meta property="og:image" content="<?php echo $previewData->image; ?>" />

		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:domain" value="<?php echo $previewData->url; ?>" />
		<meta name="twitter:title" value="<?php echo $previewData->title; ?>" />
		<meta name="twitter:description" value="<?php echo $previewData->description; ?>" />
		<meta name="twitter:image" content="<?php echo $previewData->image; ?>" />
		<meta name="twitter:url" value="<?php echo $previewData->url; ?>" />
	</head>
	<body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $googleTagManager; ?>"
                          height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<a class="navbar-brand" href="/"><img class="nav-icon" src="/images/globe.png" /> <?php echo $translator->getTranslatedString("title"); ?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fas fa-bars"></i>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="#home"><i class="fas fa-home"></i> <?php echo $translator->getTranslatedString("home"); ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#contact"><i class="fas fa-paper-plane"></i> <?php echo $translator->getTranslatedString("contactFormTitle"); ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="https://wa.me/526611383592"><i class="fab fa-whatsapp"></i> <?php echo $translator->getTranslatedString("whatsapp"); ?></a>
					</li>
				</ul>
				<ul class="navbar-nav">
					<li class="nav-item">
						<span class="nav-link" id="localeLink"><img class="nav-icon" src="<?php echo $translator->getTranslatedString("imgFlag"); ?>" /> <?php echo $translator->getTranslatedString("changeLocale"); ?></span>
					</li>
				</ul>
			</div>
		</nav>

		<main id="mainContainer" role="main" class="container">
			<div class="jumbotron">
				<h1><?php echo $translator->getTranslatedString("title"); ?></h1>
				<p class="lead"><?php echo $translator->getTranslatedString("lead"); ?></p>
			</div>
			<div id="home" class="mt-3 row">
				<div class="col-md-4">
					<div class="card shadow-sm">
						<div class="card-header">
							<h3 class="card-title"><i class="fas fa-balance-scale"></i> <?php echo $translator->getTranslatedString("cardOneTitle"); ?></h3>
						</div>
						<div class="card-body">
							<p class="card-text"><? echo $translator->getTranslatedString("cardOneText"); ?></p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card shadow-sm">
						<div class="card-header">
							<h3 class="card-title"><i class="fas fa-passport"></i> <?php echo $translator->getTranslatedString("cardTwoTitle"); ?></h3>
						</div>
						<div class="card-body">
							<p class="card-text"><?php echo $translator->getTranslatedString("cardTwoText"); ?></p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card shadow-sm">
						<div class="card-header">
							<h3 class="card-title"><i class="fas fa-handshake"></i> <?php echo $translator->getTranslatedString("cardThreeTitle"); ?></h3>
						</div>
						<div class="card-body">
							<p class="card-text"><?php echo $translator->getTranslatedString("cardThreeText"); ?></p>
						</div>
					</div>
				</div>
			</div>
			<h2 id="contact" class="mt-3"><?php echo $translator->getTranslatedString("contactFormTitle"); ?></h2>
			<form id="contactForm" novalidate>
				<div class="form-group">
					<label for="contactName"><?php echo $translator->getTranslatedString("contactName"); ?></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user" aria-hidden="true"></i></span>
						</div>
						<input id="contactName" name="contactName" type="text" class="form-control" placeholder="<?php echo $translator->getTranslatedString("contactName"); ?>" required />
					</div>
					<p id="contactNameMessage" class="alert alert-danger message mt-3"><?php echo $translator->getTranslatedString("contactNameMessage"); ?></p>
				</div>
				<div class="form-group">
					<label for="contactEmail"><?php echo $translator->getTranslatedString("contactEmail"); ?></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-envelope" aria-hidden="true"></i></span>
						</div>
						<input id="contactEmail" name="contactEmail" type="email" class="form-control" placeholder="<?php echo $translator->getTranslatedString("contactEmail"); ?>" required />
					</div>
					<p id="contactEmailMessage" class="alert alert-danger message mt-3"><?php echo $translator->getTranslatedString("contactEmailMessage"); ?></p>
				</div>
				<div class="form-group">
					<label for="contactSubject"><?php echo $translator->getTranslatedString("contactSubject"); ?></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-pencil-alt" aria-hidden="true"></i></span>
						</div>
						<input id="contactSubject" name="contactSubject" class="form-control" placeholder="<?php echo $translator->getTranslatedString("contactSubject"); ?>" required />
					</div>
					<p id="contactSubjectMessage" class="alert alert-danger message mt-3"><?php echo $translator->getTranslatedString("contactSubjectMessage"); ?></p>
				</div>
				<div class="form-group">
					<label for="contactMessage"><?php echo $translator->getTranslatedString("contactMessage"); ?></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-pencil-alt" aria-hidden="true"></i></span>
						</div>
						<textarea id="contactMessage" name="contactMessage" class="form-control" placeholder="<?php echo $translator->getTranslatedString("contactMessage"); ?>" rows="5" required></textarea>
					</div>
					<p id="contactMessageMessage" class="alert alert-danger message mt-3"><?php echo $translator->getTranslatedString("contactMessageMessage"); ?></p>
				</div>
				<div class="g-recaptcha" data-sitekey="<?php echo $recaptcha->siteKey; ?>"></div>
				<button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i> Send</button>
				<button id="resetButton" class="btn btn-warning" type="reset"><i class="fa fa-ban"></i> Reset</button>
			</form>
			<div id="outputArea" class="alert"></div>
			<div class="mt-3">
				<h2><?php echo $translator->getTranslatedString("map"); ?></h2>
				<div id="googleMap"></div>
			</div>
		</main>
	</body>
</html>
