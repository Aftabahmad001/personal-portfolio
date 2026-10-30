<?php
declare(strict_types=1);

// Local XAMPP defaults. Prefer environment variables when deploying.
function database(): PDO
{
    $host = getenv('PORTFOLIO_DB_HOST') ?: '127.0.0.1';
    $name = getenv('PORTFOLIO_DB_NAME') ?: 'aftab_portfolio';
    $user = getenv('PORTFOLIO_DB_USER') ?: 'root';
    $pass = getenv('PORTFOLIO_DB_PASS') ?: '';

    return new PDO("mysql:host={$host};dbname={$name};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
