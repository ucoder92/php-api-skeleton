<?php

/**
 * Session
 *
 * @package     PHP Skeleton
 * @author      Ulugbek Nuriddinov <ucoder92@gmail.com>
 * @link        https://github.com/ucoder92/php-api-skeleton
 * @since       1.0.0
 */

namespace Libs;

class Session
{
    /**
     * Session start
     *
     * @return void
     */
    public static function start()
    {
        if (self::is_session_started() === false) {
            session_start();
        }
    }

    /**
     * Destroy session
     *
     * @return void
     */
    public static function destroy()
    {
        if (self::is_session_started() === true) {
            unset($_SESSION);
        }
    }

    /**
     * Is session started
     *
     * @return boolean
     */
    public static function is_session_started()
    {
        if (php_sapi_name() !== 'cli') {
            return session_status() === PHP_SESSION_ACTIVE ? true : false;
        }

        return false;
    }

    /**
     * Get session data
     *
     * @param string $name
     * @param boolean $default
     * @return void
     */
    public static function get($name, $default = false)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return $default;
    }

    /**
     * Set session data
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Unset session item
     *
     * @param [type] $name
     * @return void
     */
    public static function unset($name)
    {
        unset($_SESSION[$name]);
    }
}
