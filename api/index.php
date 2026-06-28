<?php

/**
 * Create writable storage directories in /tmp for Vercel
 */
define('IS_VERCEL', true);

if (defined('IS_VERCEL')) {
    $dirs = [
        '/tmp/storage/app',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/framework/views',
        '/tmp/storage/logs',
        '/tmp/bootstrap/cache',
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
    
    // Inject cache paths so Laravel's PackageManifest doesn't crash during create()
    $_SERVER['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';
    $_SERVER['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';
    $_SERVER['APP_CONFIG_CACHE'] = '/tmp/bootstrap/cache/config.php';
    $_SERVER['APP_ROUTES_CACHE'] = '/tmp/bootstrap/cache/routes-v7.php';
    $_SERVER['APP_EVENTS_CACHE'] = '/tmp/bootstrap/cache/events.php';
}

/**
 * Forward Vercel requests to normal index.php
 */
require __DIR__ . '/../public/index.php';
