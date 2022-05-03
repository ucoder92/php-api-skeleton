<?php

/**
 * App
 *
 * @package     PHP Skeleton
 * @author      Ulugbek Nuriddinov <ucoder92@gmail.com>
 * @link        https://github.com/ucoder92/php-api-skeleton
 * @since       1.0.0
 */

class App
{
    private static $db = null;

    /**
     * App
     */
    public function __construct()
    {
        $session = get_config('session');

        if ($session['active']) {
            Libs\Session::start();
        }
    }

    /**
     * Run app
     *
     * @return void
     */
    public function run()
    {
        $this->check_cors();
        $action = input_get('action');

        if ($action) {
            $file = ACTIONS_PATH . $action . '.php';

            if (is_file($file)) {
                return include($file);
            }
        }

        return json_response();
    }

    /**
     * Get database
     *
     * @return void
     */
    public static function db()
    {
        if (is_null(self::$db)) {
            self::$db = connect_db();
        }

        return self::$db;
    }

    /**
     * Check cors
     *
     * @return mixed
     */
    public function check_cors()
    {
        $security = get_config('security');
        $cors_check = array_value($security, 'cors');

        if (!$cors_check) {
            return false;
        }

        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
    }
}
