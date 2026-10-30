<?php
$pageTitle = 'Technical Skills | Aftab Ahmad Wafa';
$pageDescription = 'Technical skills of Aftab Ahmad Wafa: HTML, CSS, JavaScript, PHP, MySQL, Bootstrap, Git, and GitHub.';
$activePage = 'skills';
require __DIR__ . '/includes/header.php';
$skillGroups = [
  'Frontend' => [['fa-brands fa-html5','HTML5','Semantic, accessible page structure.'],['fa-brands fa-css3-alt','CSS3','Responsive layouts and polished interfaces.'],['fa-brands fa-js','JavaScript','Useful browser interactions with vanilla JavaScript.'],['fa-brands fa-bootstrap','Bootstrap 5','Efficient, responsive interface building.']],
  'Backend & Data' => [['fa-brands fa-php','PHP','Server-side applications and form handling.'],['fa-solid fa-database','MySQL','Structured, database-driven application data.']],
  'Tools & Workflow' => [['fa-brands fa-git-alt','Git','Version control for organized development.'],['fa-brands fa-github','GitHub','Code collaboration and repository workflow.'],['fa-solid fa-code','VS Code','A focused environment for development.']]
];
?>
<main id="main-content"><section class="page-hero"><div class="container narrow"><p class="eyebrow">Technical skills</p><h1>Tools chosen to build solid web experiences.</h1><p class="lead">A practical toolkit for responsive websites and database-driven applications—presented without inflated scores or claims.</p></div></section><section class="section container"><?php foreach ($skillGroups as $group => $skills): ?><div class="skill-group"><h2><?= e($group) ?></h2><div class="skills-grid"><?php foreach ($skills as [$icon, $name, $description]): ?><article class="skill-card reveal"><i class="<?= e($icon) ?>"></i><h3><?= e($name) ?></h3><p><?= e($description) ?></p></article><?php endforeach; ?></div></div><?php endforeach; ?></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
