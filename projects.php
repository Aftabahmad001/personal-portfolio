<?php
$pageTitle = 'Projects | Aftab Ahmad Wafa';
$pageDescription = 'Selected development projects by Aftab Ahmad Wafa.';
$activePage = 'projects';
require __DIR__ . '/includes/header.php';
$projects = [
//  ['web php','Afghanistan Education Management System','Education data management','A PHP/MySQL web application concept for organizing student and institution information with dashboards and reporting workflows.','PHP, MySQL, HTML, CSS','fa-solid fa-graduation-cap'],

 ['web php','Shop Management System','Sales and inventory workflow','A business management application focused on sales, inventory, customers, suppliers, expenses, and financial reporting. Features should be verified against the current build.','PHP, MySQL, JavaScript','fa-solid fa-store'],


//  ['mobile','Dukan Hisab Lite','Offline-first shop companion','A Flutter-based Android project for local shop records. Sales, products, customers, and expenses are part of its direction; implemented capabilities should be confirmed in the app build.','Flutter, Dart, Mobile','fa-solid fa-mobile-screen-button']
];
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container narrow">
            <p class="eyebrow">Portfolio projects</p>
            <h1>Systems designed around everyday work.</h1>
            <p class="lead">A growing collection of practical development projects. No live links or repositories are shown until they are genuinely configured.</p>
        </div>
    </section>

    <section class="section container">

        <div class="project-filters" role="group" aria-label="Filter projects">
            <button class="filter-button active" data-filter="all">All</button>
            <button class="filter-button" data-filter="web">Web Applications</button>
            <button class="filter-button" data-filter="php">PHP / MySQL</button>
            <button class="filter-button" data-filter="mobile">Mobile Apps</button>
        </div>

        <div class="projects-grid"><?php foreach ($projects as [$categories,$title,$subtitle,$description,$tech,$icon]): ?>
            <article class="project-card reveal" data-category="<?= e($categories) ?>">

                <div class="project-art">
                    <i class="<?= e($icon) ?>"></i>
                    <span>Illustrative project mockup</span>
                </div>

                <div class="project-body">
                    <p class="tag"><?= e($subtitle) ?></p>
                    <h2><?= e($title) ?></h2>
                    <p><?= e($description) ?></p>
                    <p class="technology"><i class="fa-solid fa-code"></i> <?= e($tech) ?></p>
                    <span class="text-link muted">Project details available on request</span>
                </div>

            </article><?php endforeach; ?>
        </div>

    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
