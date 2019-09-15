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
?>
<!DOCTYPE html>
<html lang="<?php echo $locale;?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title><?php echo $translator->getTranslatedString("title"); ?></title>
	</head>
	<body>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<a class="navbar-brand" href="#">Fixed navbar</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fas fa-bars"></i>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Disabled</a>
					</li>
				</ul>
				<ul class="navbar-nav">
					<li class="nav-item">
						<span class="nav-link" id="localeLink"><img class="flag-icon" src="<?php echo $translator->getTranslatedString("imgFlag"); ?>" /> <?php echo $translator->getTranslatedString("changeLocale"); ?></span>
					</li>
				</ul>
			</div>
		</nav>

		<main role="main" class="container">
			<div class="jumbotron">
				<h1><?php echo $translator->getTranslatedString("title"); ?></h1>
				<p class="lead"><?php echo $translator->getTranslatedString("title"); ?></p>
				<a class="btn btn-lg btn-primary" href="/docs/4.3/components/navbar/" role="button">View navbar docs &raquo;</a>
			</div>
			<div class="row">
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
		</main>
	</body>
</html>
