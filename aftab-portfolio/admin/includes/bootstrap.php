<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

function admin_url(string $path = ''): string
{
    return url('admin/' . ltrim($path, '/'));
}

function admin_start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['SERVER_PORT'] ?? null) === '443');
    session_name('aftab_portfolio_admin');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function admin_csrf_token(): string
{
    admin_start_session();
    if (empty($_SESSION['admin_csrf'])) {
        $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['admin_csrf'];
}

function admin_verify_csrf(): void
{
    admin_start_session();
    $submitted = (string) ($_POST['csrf_token'] ?? '');
    if (!hash_equals((string) ($_SESSION['admin_csrf'] ?? ''), $submitted)) {
        http_response_code(400);
        exit('Invalid request. Please return to the dashboard and try again.');
    }
}

function require_admin(): void
{
    admin_start_session();
    if (empty($_SESSION['admin_user_id'])) {
        header('Location: ' . admin_url('login.php'), true, 303);
        exit;
    }
}

function admin_flash(string $key, ?string $value = null): ?string
{
    admin_start_session();
    if ($value !== null) {
        $_SESSION['admin_flash'][$key] = $value;
        return null;
    }
    $message = $_SESSION['admin_flash'][$key] ?? null;
    unset($_SESSION['admin_flash'][$key]);
    return $message;
}
