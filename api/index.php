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
}

/**
 * Forward Vercel requests to normal index.php
 */
require __DIR__ . '/../public/index.php';
