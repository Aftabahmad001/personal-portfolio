<?php
session_start();
require_once __DIR__ . '/config/config.php';
if (empty($_SESSION['csrf_token'])) 
    { 
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
    }
$pageTitle = 'Contact | Aftab Ahmad Wafa';
$pageDescription = 'Contact Aftab Ahmad Wafa about website and web application development.';
$activePage = 'contact';
$form = $_SESSION['contact_form'] ?? [];
$errors = $_SESSION['contact_errors'] ?? [];
$success = $_SESSION['contact_success'] ?? '';
unset($_SESSION['contact_form'], $_SESSION['contact_errors'], $_SESSION['contact_success']);

require __DIR__ . '/includes/header.php';?>

<main id="main-content">
    <section class="page-hero contact-hero">
        <div class="container narrow">
            <p class="eyebrow">Contact</p>
            <h1>Let’s talk about what you’re building.</h1>
            <p class="lead">Tell me a little about your project. Your message is stored securely for follow-up; email delivery is not claimed unless separately configured.</p>
        </div>
    </section>
    <section class="section container contact-layout">
        <div>
            <p class="eyebrow">Send a message</p>
            <?php if ($success): ?>
                <div class="alert success" role="status">
                    <?= e($success) ?>
                </div>
            <?php endif; ?>
            <?php if ($errors): ?>
                <div class="alert error" role="alert">Please correct the highlighted fields and try again.</div>
            <?php endif; ?>
            <form action="<?= e(url('contact-submit.php')) ?>" method="post" class="contact-form">
                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                    <input type="text" name="website" class="honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">
                    <div class="form-row"><div>
                        <label for="name">Name</label>
                        <input id="name" name="name" value="<?= e($form['name'] ?? '') ?>" required maxlength="100" aria-invalid="<?= isset($errors['name']) ? 'true' : 'false' ?>"><?php if(isset($errors['name'])): ?>
                            <small><?= e($errors['name']) ?></small>
                            <?php endif; ?>
                            </div>
                            <div>
                                <label for="email">Email</label>
                                <input id="email" type="email" name="email" value="<?= e($form['email'] ?? '') ?>" required maxlength="190" aria-invalid="<?= isset($errors['email']) ? 'true' : 'false' ?>"><?php if(isset($errors['email'])): ?>
                                    <small><?= e($errors['email']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-row"><div>
                                <label for="subject">Service / subject</label>
                                <select id="subject" name="subject" required>
                                    <option value="">Select an option</option>
                                    <?php foreach(['Business website','Web application','PHP & MySQL development','Website redesign','Maintenance or bug fixing','Other'] as $option): ?>
                                        <option <?= ($form['subject'] ?? '') === $option ? 'selected' : '' ?>><?= e($option) ?></option>
                                        <?php endforeach; ?>
                                </select><?php if(isset($errors['subject'])): ?>
                                    <small><?= e($errors['subject']) ?></small>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <label for="budget">Project budget <span>(optional)</span></label>
                                    <input id="budget" name="budget" value="<?= e($form['budget'] ?? '') ?>" maxlength="100" placeholder="e.g. To be discussed">
                                </div>
                            </div>
                            <div>
                                <label for="message">Project details</label>
                                <textarea id="message" name="message" required maxlength="5000" rows="7" aria-invalid="<?= isset($errors['message']) ? 'true' : 'false' ?>"><?= e($form['message'] ?? '') ?></textarea>
                                <?php if(isset($errors['message'])): ?>
                                <small><?= e($errors['message']) ?></small>
                                <?php endif; ?>
                            </div>
                                <button class="button button-primary" type="submit">Send message <i class="fa-solid fa-paper-plane"></i></button>
                            </form>
                        </div>
                        <aside class="contact-aside">
                            
                            <i class="fa-regular fa-envelope"></i>
                            <h2>Based in Kabul</h2>
                            <p>Available to discuss websites and practical web applications for businesses and organizations.</p>
                            <?php if(SITE_EMAIL): ?>
                            <a class="text-link" href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a>
                            <?php endif; ?><?php if(WHATSAPP_URL): ?>
                            <a class="text-link" href="<?= e(WHATSAPP_URL) ?>" target="_blank" rel="noopener">WhatsApp <i class="fa-brands fa-whatsapp"></i></a>
                            <?php endif; ?>
                        </aside>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
