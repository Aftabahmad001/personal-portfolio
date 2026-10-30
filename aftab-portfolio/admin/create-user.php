<?php
declare(strict_types=1);

// CLI-only account bootstrap. It cannot be run through the public web server.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/../config/database.php';

$email = strtolower(trim((string) ($argv[1] ?? '')));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDERR, "Usage: php admin/create-user.php admin@example.com\n");
    exit(1);
}

fwrite(STDOUT, "Enter a password (minimum 12 characters): ");
$password = trim((string) fgets(STDIN));
if (strlen($password) < 12) {
    fwrite(STDERR, "Password must be at least 12 characters.\n");
    exit(1);
}

try {
    $existingAccounts = (int) database()->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
    if ($existingAccounts > 0) {
        fwrite(STDERR, "An admin account already exists. This first-account setup is now disabled.\n");
        exit(1);
    }
    $statement = database()->prepare('INSERT INTO admin_users (email, password_hash) VALUES (:email, :password_hash)');
    $statement->execute(['email' => $email, 'password_hash' => password_hash($password, PASSWORD_DEFAULT)]);
    fwrite(STDOUT, "Admin account created successfully.\n");
} catch (PDOException $exception) {
    error_log('Admin user creation error: ' . $exception->getMessage());
    fwrite(STDERR, "Account could not be created. Ensure database-admin.sql has been run and the email is unused.\n");
    exit(1);
}
