<?php
// Input get
function input_get($key, $default = false)
{
    if (isset($_GET[$key])) {
        $query = $_GET[$key];

        if (is_array($query) && $query) {
            $output = clean_array($query);
        } else {
            $output = clean_str($query);
        }

        return $output;
    }

    return $default;
}

// Input post
function input_post($key, $default = false)
{
    if (isset($_POST[$key])) {
        $post = $_POST[$key];

        if (is_array($post) && $post) {
            $output = clean_array($post);
        } else {
            $output = clean_str($post);
        }

        return $output;
    }

    return $default;
}

// Cookie value
function cookie_value($key = false, $default = false)
{
    if (isset($_COOKIE[$key]) && $_COOKIE[$key]) {
        return $_COOKIE[$key];
    }

    return $default;
}

// Request value
function request_value($key = false, $default = false)
{
    if (isset($_REQUEST[$key]) && $_REQUEST[$key]) {
        return $_REQUEST[$key];
    }

    return $default;
}

// Session value
function session_value($key = false, $default = false)
{
    if (isset($_SESSION[$key]) && $_SESSION[$key]) {
        return $_SESSION[$key];
    }

    return $default;
}

// Get IP address
function get_ip_address()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }

    return null;
}
