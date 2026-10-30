<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

function setup_unavailable(): void
{
    http_response_code(404);
    exit('Not found.');
}

$setupKey = getenv('PORTFOLIO_ADMIN_SETUP_KEY') ?: ADMIN_SETUP_KEY;
if ($setupKey === '') {
    setup_unavailable();
}

try {
    $adminCount = (int) database()->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
} catch (PDOException $exception) {
    error_log('Admin setup database error: ' . $exception->getMessage());
    http_response_code(503);
    exit('Admin setup is unavailable. Import database-admin.sql into the active database first.');
}

if ($adminCount > 0) {
    setup_unavailable();
}

admin_start_session();
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();
    $submittedKey = (string) ($_POST['setup_key'] ?? '');
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $confirmation = (string) ($_POST['password_confirmation'] ?? '');

    if (!hash_equals($setupKey, $submittedKey)) {
        $error = 'Invalid setup key.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email address.';
    } elseif (strlen($password) < 12) {
        $error = 'Use a password with at least 12 characters.';
    } elseif (!hash_equals($password, $confirmation)) {
        $error = 'The passwords do not match.';
    } else {
        try {
            $statement = database()->prepare('INSERT INTO admin_users (email, password_hash) VALUES (:email, :password_hash)');
            $statement->execute(['email' => $email, 'password_hash' => password_hash($password, PASSWORD_DEFAULT)]);
            session_regenerate_id(true);
            $_SESSION['admin_user_id'] = (int) database()->lastInsertId();
            $_SESSION['admin_user_email'] = $email;
            header('Location: ' . admin_url('index.php'), true, 303);
            exit;
        } catch (PDOException $exception) {
            error_log('Admin setup creation error: ' . $exception->getMessage());
            $error = 'The account could not be created. Check the database and try again.';
        }
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Create first admin account</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"><link rel="stylesheet" href="<?= e(url('admin/admin.css')) ?>"></head><body class="admin-body"><main class="login-card admin-card"><p class="admin-kicker">One-time setup</p><h1 class="h2 admin-title">Create administrator</h1><p class="text-secondary">This page permanently disables itself after the first account is created.</p><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf_token" value="<?= e(admin_csrf_token()) ?>"><div class="mb-3"><label class="form-label" for="setup_key">Setup key</label><input class="form-control" id="setup_key" name="setup_key" type="password" required></div><div class="mb-3"><label class="form-label" for="email">Administrator email</label><input class="form-control" id="email" name="email" type="email" autocomplete="username" required></div><div class="mb-3"><label class="form-label" for="password">Password</label><input class="form-control" id="password" name="password" type="password" autocomplete="new-password" minlength="12" required></div><div class="mb-4"><label class="form-label" for="password_confirmation">Confirm password</label><input class="form-control" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="12" required></div><button class="btn btn-primary w-100" type="submit">Create secure account</button></form></main></body></html>
