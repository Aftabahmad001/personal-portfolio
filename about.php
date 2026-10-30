<?php
$pageTitle = 'About | Aftab Ahmad Wafa';
$pageDescription = 'Learn about Aftab Ahmad Wafa, a Computer Science graduate and professional web developer.';
$activePage = 'about';
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
  <section class="page-hero about-hero"><div class="container narrow"><p class="eyebrow">About me</p><h1>A practical builder with a focus on useful solutions.</h1><p class="lead">I’m Aftab Ahmad Wafa, a web developer who enjoys turning ideas into clean, dependable digital experiences.</p></div></section>
  <section class="section container about-layout"><div class="about-portrait"><?php if (profile_image_url()): ?><img src="<?= e(profile_image_url()) ?>" alt="Portrait of Aftab Ahmad Wafa"><?php endif; ?><div class="profile-fallback"><i class="fa-solid fa-laptop-code"></i><span>AW</span></div></div><div><p class="eyebrow">My background</p><h2>Technology that serves a real purpose.</h2><p>I graduated in Computer Science from Khurasan University in 2025. My work centers on full-stack web development, responsive interfaces, and PHP/MySQL applications that make day-to-day processes easier.</p><p>I value clarity in both design and code: understanding the problem, organizing the solution, and delivering an experience people can use with confidence.</p><a class="button button-primary" href="<?= e(url('contact.php')) ?>">Start a conversation</a></div></section>
  <section class="section section-alt"><div class="container values-grid"><article><i class="fa-solid fa-compass-drafting"></i><h2>Thoughtful approach</h2><p>I begin with the user’s needs and shape the structure before adding visual polish.</p></article><article><i class="fa-solid fa-puzzle-piece"></i><h2>Problem solving</h2><p>I break complex workflows into manageable, maintainable pieces.</p></article><article><i class="fa-solid fa-seedling"></i><h2>Professional growth</h2><p>I continue developing practical skills while building software that benefits businesses.</p></article></div></section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
