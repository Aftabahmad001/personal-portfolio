<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
admin_start_session();
if (!empty($_SESSION['admin_user_id'])) { header('Location: ' . admin_url('index.php'), true, 303); exit; }

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        admin_verify_csrf();
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');
        $attempts = (int) ($_SESSION['admin_login_attempts'] ?? 0);
        $lastAttempt = (int) ($_SESSION['admin_login_last_attempt'] ?? 0);

    if ($attempts >= 5 && time() - $lastAttempt < 900) 
        {
            $error = 'Too many attempts. Please wait 15 minutes before trying again.';
        } 

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') 
        {
            $error = 'Enter your email address and password.';
        } 
        else 
            {
            try 
            {
                $statement = database()->prepare('SELECT id, email, password_hash FROM admin_users WHERE email = :email LIMIT 1');
                $statement->execute(['email' => $email]);
                $user = $statement->fetch();
            if ($user && password_verify($password, $user['password_hash'])) 
                {
                    session_regenerate_id(true);
                    $_SESSION['admin_user_id'] = (int) $user['id'];
                    $_SESSION['admin_user_email'] = $user['email'];
                    unset($_SESSION['admin_login_attempts'], $_SESSION['admin_login_last_attempt']);
                    database()->prepare('UPDATE admin_users SET last_login_at = CURRENT_TIMESTAMP WHERE id = :id')->execute(['id' => $user['id']]);
                    header('Location: ' . admin_url('index.php'), true, 303); exit;
                }
            $_SESSION['admin_login_attempts'] = $attempts + 1;
            $_SESSION['admin_login_last_attempt'] = time();
            $error = 'Invalid email address or password.';
            } 
            catch (PDOException $exception) 
            {
                error_log('Admin login error: ' . $exception->getMessage());
                $error = 'The admin service is temporarily unavailable.';
            }
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Admin sign in</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"><link rel="stylesheet" href="<?= e(url('admin/admin.css')) ?>"></head><body class="admin-body"><main class="login-card admin-card"><p class="admin-kicker">Private area</p><h1 class="h2 admin-title">Sign in</h1><p class="text-secondary">Use an administrator account to manage contact messages.</p><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><form method="post" novalidate><input type="hidden" name="csrf_token" value="<?= e(admin_csrf_token()) ?>"><div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" id="email" type="email" name="email" autocomplete="username" required></div><div class="mb-4"><label class="form-label" for="password">Password</label><input class="form-control" id="password" type="password" name="password" autocomplete="current-password" required></div><button class="btn btn-primary w-100" type="submit">Sign in securely</button></form></main></body></html>
