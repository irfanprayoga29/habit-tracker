<?php

// Suppress deprecation warnings on Vercel PHP 8.4+
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', '0');

/**
 * Create writable storage directories in /tmp for Vercel
 */
$tmpStorage = '/tmp/storage';
if (!is_dir($tmpStorage)) {
    $dirs = [
        "$tmpStorage/app",
        "$tmpStorage/framework/cache/data",
        "$tmpStorage/framework/sessions",
        "$tmpStorage/framework/views",
        "$tmpStorage/logs",
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}

/**
 * Forward Vercel requests to normal index.php
 */
require __DIR__ . '/../public/index.php';
