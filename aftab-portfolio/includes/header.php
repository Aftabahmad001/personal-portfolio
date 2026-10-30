<?php
require_once __DIR__ . '/../config/config.php';
$pageTitle = $pageTitle ?? SITE_NAME . ' | Professional Web Developer';
$pageDescription = $pageDescription ?? 'Professional web developer creating responsive websites and practical web applications.';
$activePage = $activePage ?? '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= e($pageDescription) ?>">
  <meta property="og:title" content="<?= e($pageTitle) ?>">
  <meta property="og:description" content="<?= e($pageDescription) ?>">
  <meta property="og:type" content="website">
  <title><?= e($pageTitle) ?></title>
  <link rel="preconnect" href="https://cdn.jsdelivr.net">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="<?= e(url('css/style.css')) ?>">
</head>
<body>
<a class="skip-link" href="#main-content">Skip to content</a>
<header class="site-header">
  <div class="container nav-wrap">
    <a class="brand" href="<?= e(url()) ?>" aria-label="Aftab Ahmad Wafa home">Aftab Ahmad Wafa<span>.</span></a>
    <button class="nav-toggle" type="button" aria-controls="primary-nav" aria-expanded="false"><span class="sr-only">Open menu</span><i class="fa-solid fa-bars"></i></button>
    <nav id="primary-nav" class="primary-nav" aria-label="Primary navigation">
      <?php $links = ['home' => ['Home', 'index.php'], 'about' => ['About', 'about.php'], 'skills' => ['Skills', 'skills.php'], 'projects' => ['Projects', 'projects.php'], 'services' => ['Services', 'services.php'], 'contact' => ['Contact', 'contact.php']]; ?>
      <?php foreach ($links as $key => [$label, $path]): ?>
        <a class="<?= $activePage === $key ? 'active' : '' ?>" <?= $activePage === $key ? 'aria-current="page"' : '' ?> href="<?= e(url($path)) ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
    <a class="button button-primary nav-contact" href="<?= e(url('contact.php')) ?>">Hire me</a>
  </div>
</header>
