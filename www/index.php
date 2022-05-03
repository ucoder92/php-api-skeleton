<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.boot.php';
require __DIR__ . '/../system/bootstrap.php';
require __DIR__ . '/../app.php';

// Run
$app = new App();
$app->run();
