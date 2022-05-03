<?php
return array(
    'domain' => 'www.domain.com',
    'site_url' => 'https://www.domain.com/',
    'site_name' => 'Web Site',
    'brand_name' => 'Web Site',
    'default_language' => 'en',
    'db' => array(
        'dsn' => 'mysql:host=localhost;dbname=website_db',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ),
    'security' => array(
        'cors' => false,
        'secret_iv' => '',
        'secret_key' => '',
        'cookie_validation_key' => '',
    ),
    'session' => array(
        'active' => false,
        'expiration' => 7200,
        'cookie_name' => 'app_session',
    ),
    'smtp' => array(
        'host' => '',
        'port' => 465,
        'email' => '',
        'password' => '',
        'senderName' => '',
    ),
);
