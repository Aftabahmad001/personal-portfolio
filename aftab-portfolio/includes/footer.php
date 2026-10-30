<?php require_once __DIR__ . '/../config/config.php'; ?>
<footer class="site-footer">
  <div class="container footer-grid">
    <div><a class="brand" href="<?= e(url()) ?>">Aftab Ahmad Wafa<span>.</span></a><p>Professional web developer building modern, practical digital solutions.</p></div>
    <div><h2>Explore</h2><a href="<?= e(url('about.php')) ?>">About</a><a href="<?= e(url('projects.php')) ?>">Projects</a><a href="<?= e(url('contact.php')) ?>">Contact</a></div>
    <div><h2>Let’s connect</h2><?php if (SITE_EMAIL): ?><a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a><?php endif; ?><?php if (GITHUB_URL): ?><a href="<?= e(GITHUB_URL) ?>" target="_blank" rel="noopener">GitHub</a><?php endif; ?><p>  Kabul, Afghanistan</p></div>
  </div>
  <div class="container footer-bottom">© <?= date('Y') ?> Aftab Ahmad Wafa. Built with PHP, care, and clean code.</div>
</footer>
<button class="back-to-top" type="button" aria-label="Back to top"><i class="fa-solid fa-arrow-up"></i></button>
<script src="<?= e(url('js/script.js')) ?>"></script>
</body></html>
