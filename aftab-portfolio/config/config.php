<?php
declare(strict_types=1);

/*
 * URL paths are calculated from the document root so one codebase works in:
 * - XAMPP:      http://localhost/aftab-portfolio/
 * - InfinityFree/document root: https://your-domain.example/
 *
 * PORTFOLIO_BASE_PATH may be set by a host when an explicit override is needed.
 */
const SITE_NAME = 'Aftab Ahmad Wafa';
// Configure this address for the public contact section.
const SITE_EMAIL = 'aftabahmad.wafa@hotail.com';
const WHATSAPP_URL = 'https://wa.me/93781461504';
const GITHUB_URL = 'https://github.com/Aftabahmad001/Wafa';
const LINKEDIN_URL = '';
// Leave empty normally. Set a long, unique temporary value only when using admin/setup.php.
const ADMIN_SETUP_KEY = 'your-long-random-secret';

function base_path(): string
{
    static $basePath = null;
    if ($basePath !== null) {
        return $basePath;
    }

    $configuredPath = getenv('PORTFOLIO_BASE_PATH');
    if ($configuredPath !== false) {
        $configuredPath = trim($configuredPath);
        $basePath = $configuredPath === '' ? '' : '/' . trim($configuredPath, '/');
        return $basePath;
    }

    $documentRoot = realpath((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''));
    $applicationRoot = realpath(__DIR__ . '/..');
    if ($documentRoot !== false && $applicationRoot !== false) {
        $documentRoot = rtrim(str_replace('\\', '/', $documentRoot), '/');
        $applicationRoot = rtrim(str_replace('\\', '/', $applicationRoot), '/');
        if ($applicationRoot === $documentRoot) {
            return $basePath = '';
        }
        if (substr($applicationRoot, 0, strlen($documentRoot) + 1) === $documentRoot . '/') {
            return $basePath = substr($applicationRoot, strlen($documentRoot));
        }
    }

    // Safe fallback for local CLI execution and the standard XAMPP layout.
    return $basePath = '/aftab-portfolio';
}

function url(string $path = ''): string
{
    $resource = ltrim($path, '/');
    $basePath = base_path();
    if ($resource === '') {
        return $basePath === '' ? '/' : $basePath . '/';
    }

    return ($basePath === '' ? '' : $basePath) . '/' . $resource;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function profile_image_url(): ?string
{
    return is_file(__DIR__ . '/../assets/images/profile.jpg') ? url('assets/images/profile.jpg') : null;
}
