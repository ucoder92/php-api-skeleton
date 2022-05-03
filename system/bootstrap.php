<?php

/**
 * App starter
 *
 * @package     PHP Skeleton
 * @author      Ulugbek Nuriddinov <ucoder92@gmail.com>
 * @link        https://github.com/ucoder92/php-api-skeleton
 * @since       1.0.0
 */

if (ENVIRONMENT == 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

require __DIR__ . '/array.php';
require __DIR__ . '/base.php';
require __DIR__ . '/input.php';
require __DIR__ . '/strings.php';
require __DIR__ . '/tools.php';
require __DIR__ . '/db.php';
