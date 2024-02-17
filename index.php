<?php
require_once('./php/xsrf.php');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
setXsrfCookie();

$description = 'En Corporativo Juridico Internacional nos comprometemos en un trato personalizado en asuntos de derecho corporativo internacional y migraci&oacute;n. Te invitamos a conocer nuestras soluciones experimentados personalizados a tu necesidad.';
$title = 'Corporativo Juridico Internacional';
$url = 'https://www.corpjuridicoint.com';
$image = $url . '/images/corpjuridicoint-logo.png';
?>
<!doctype html>
<html lang="en">
  <head>
    <title><?php echo $title; ?></title>
    <meta charset="UTF-8" />
    <link rel="icon" href="/images/globe.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo $description; ?>" />

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="<?php echo $url; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo $description; ?>" />
    <meta property="og:image" content="<?php echo $image; ?>" />

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="twitter:domain" content="corpjuridicoint.com" />
    <meta property="twitter:url" content="<?php echo $url; ?>" />
    <meta name="twitter:title" content="<?php echo $title; ?>" />
    <meta name="twitter:description" content="<?php echo $description; ?>" />
    <meta name="twitter:image" content="<?php echo $image; ?>" />
  </head>
  <body>
    <div id="app"></div>
    <script type="module" src="/src/main.ts"></script>
  </body>
</html>
