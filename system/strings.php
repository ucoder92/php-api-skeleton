<?php
// Clean string
function clean_str($val)
{
    return trim(htmlentities($val, ENT_QUOTES, 'UTF-8'));
}

// Clean string for numbers
function clean_numbers($string)
{
    $output = preg_replace('/[^0-9.,]/', '', $string);
    $output = clean_str($output);
    return $output;
}

// Clean array
function clean_array($array)
{
    $output = array();

    if ($array) {
        foreach ($array as $key => $value) {
            $clear_key = clean_str($key);

            if (is_array($value) && $value) {
                $clear_value = clean_array($value);
            } else {
                $clear_value = clean_str($value);
            }

            $output[$clear_key] = $clear_value;
        }
    }

    return $output;
}

// Generate random string
function random_string($type = 'alnum', $len = 8)
{
    switch ($type) {
        case 'alpha':
            $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 'alpha-lower':
            $pool = 'abcdefghijklmnopqrstuvwxyz';
            break;
        case 'alnum':
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 'alnum-lower':
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
            break;
        case 'numeric':
            $pool = '0123456789';
            break;
        case 'nozero':
            $pool = '123456789';
            break;
    }

    return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
}

// Remove all chars from string
function remove_all($string, $except = false)
{
    if ($string && $except == 'letters') {
        return preg_replace('/[^a-zA-Z]/', '', $string);
    }

    if ($string && $except == 'numbers') {
        return preg_replace('/[^0-9.]/', '', $string);
    }

    if ($string && $except == 'letters-numbers') {
        return preg_replace('/[^a-zA-Z0-9.]/', '', $string);
    }

    return false;
}

// Remove all spaces from string
function remove_spaces($string)
{
    $stripped = preg_replace('/\s+/', ' ', $string);
    return preg_replace('/\s/', '', $stripped);
}

// Trim slashes
function trim_slashes($str)
{
    return trim($str, '/');
}

// String to lower
function str_to_lower($str)
{
    return mb_strtolower($str, 'UTF-8');
}

// String to lower
function str_to_upper($str)
{
    return mb_strtoupper($str, 'UTF-8');
}

// String to lower
function str_to_title($str)
{
    return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
}

// Obfuscate email address
function obfuscate_email($email_address = false)
{
    $output = $email_address;
    $explode = explode("@", $email_address);
    $name = array_value($explode, 0);
    $name_fchars = substr($name, 0, 2);
    $name_length = strlen($name);
    $email = array_value($explode, 1);
    $email_fchars = substr($email, 0, 3);
    $email_lchars = substr($email, -3);
    $email_length = strlen($email);

    if ($name_length > 0 && $email_length > 0) {
        $output = $name_fchars . str_repeat('*', ($name_length - 2));
        $output .= '@';
        $output .= $email_fchars . str_repeat('*', ($email_length - 6)) . $email_lchars;
    }

    return $output;
}
