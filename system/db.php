<?php

// Connect database
function connect_db()
{
    $configs = get_config('db');
    $dsn = array_value($configs, 'dsn');
    $username = array_value($configs, 'username');
    $password = array_value($configs, 'password');

    try {
        $connection = new PDO($dsn, $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $connection;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}
