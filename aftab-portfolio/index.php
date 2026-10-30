<?php
$pageTitle = 'Aftab Ahmad Wafa | Professional Web Developer';
$pageDescription = 'Aftab Ahmad Wafa builds responsive websites and practical web applications.';
$activePage = 'home';
require __DIR__ . '/includes/header.php';
?>

<main id="main-content">
    <section class="home-hero">
        <div class="container hero-grid">
            <div class="hero-copy">
                <p class="availability"><i class="fa-solid fa-circle"></i> Available for web projects</p>
                <p class="eyebrow">Kabul, Afghanistan</p>
                <h1>Professional <span>Web Developer</span></h1>
                <p class="hero-intro">I’m Aftab Ahmad Wafa. I design and build responsive, user-friendly websites and practical web applications with a focus on clear experiences and dependable code.</p>
                <div class="hero-actions">
                    <a class="button button-primary" href="<?= e(url('projects.php')) ?>">View My Projects <i class="fa-solid fa-arrow-right"></i></a>
                    <a class="button button-secondary" href="<?= e(url('contact.php')) ?>">Let’s Work Together</a>
                </div>
                <ul class="tech-badges" aria-label="Core technologies">
                    <li>PHP</li><li>JavaScript</li><li>MySQL</li><li>HTML5</li><li>CSS3</li><li>Bootstrap</li>
                </ul>
            </div>

            <div class="hero-portrait reveal">
                <div class="portrait-glow"></div>
                <div class="portrait-card">
                    <?php if (profile_image_url()): ?>
                        <img src="<?= e(profile_image_url()) ?>" alt="Portrait of Aftab Ahmad Wafa">
                    <?php else: ?>
                        <div class="profile-fallback" aria-label="Profile image placeholder"><i class="fa-solid fa-code"></i><span>AW</span></div>
                    <?php endif; ?>
                </div>
                <div class="portrait-note"><i class="fa-solid fa-code"></i> Building useful digital solutions</div>
            </div>
        </div>
    </section>

    <section class="home-section featured-projects">
        <div class="container">
            <div class="home-section-heading">
                <div><p class="eyebrow">Selected work</p><h2>Projects built for everyday work.</h2></div>
                <a class="text-link" href="<?= e(url('projects.php')) ?>">Explore all projects <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="home-project-grid">
                <article class="home-project-card reveal">
                    <div class="card-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <p class="tag">PHP · MySQL</p><h3>Afghanistan Education Management System</h3>
                    <p>Organizing student and institution information through practical dashboards and reporting workflows.</p>
                    <span class="project-status">In progress</span>
                </article>
                <article class="home-project-card reveal">
                    <div class="card-icon"><i class="fa-solid fa-store"></i></div>
                    <p class="tag">Web application</p><h3>Shop Management System</h3>
                    <p>A focused business tool for sales, inventory, customer, supplier, and expense workflows.</p>
                    <span class="project-status">In progress</span>
                </article>
                <article class="home-project-card reveal">
                    <div class="card-icon"><i class="fa-solid fa-mobile-screen-button"></i></div>
                    <p class="tag">Flutter · Dart</p><h3>Dukan Hisab Lite</h3>
                    <p>An offline-first direction for local shop records, sales, products, and expenses.</p>
                    <span class="project-status">In progress</span>
                </article>
            </div>
        </div>
    </section>

    <section class="home-services">
        <div class="container">
            <div class="home-section-heading"><div><p class="eyebrow">What I do</p><h2>Digital work that solves practical problems.</h2></div></div>
            <div class="service-grid">
                <article><i class="fa-solid fa-laptop-code"></i><h3>Custom websites</h3><p>Clear, modern sites designed to present your work and services well.</p></article>
                <article><i class="fa-solid fa-database"></i><h3>PHP &amp; MySQL</h3><p>Database-driven functionality for tools that need more than a brochure site.</p></article>
                <article><i class="fa-solid fa-mobile-screen-button"></i><h3>Responsive design</h3><p>Interfaces that remain comfortable and useful on every screen size.</p></article>
            </div>
        </div>
    </section>

    <section class="container final-cta reveal">
        <p class="eyebrow">Start a conversation</p>
        <h2>Have a project in mind?</h2>
        <p>Let’s discuss a website or application that supports your next step.</p>
        <a class="button button-primary" href="<?= e(url('contact.php')) ?>">Contact me <i class="fa-solid fa-arrow-right"></i></a>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
