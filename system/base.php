<?php
// Check cli mode
function is_cli()
{
    if (php_sapi_name() == "cli") {
        return true;
    }

    return false;
}

// Check development mode
function is_development_mode()
{
    return (ENVIRONMENT == 'development') ? true : false;
}

// Check url
function is_url($url)
{
    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return false;
    }

    return true;
}

// Check email address
function is_email($string)
{
    if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
        return true;
    }

    return false;
}

function is_session_started()
{
    if (php_sapi_name() !== 'cli') {
        return session_status() === PHP_SESSION_ACTIVE ? true : false;
    }

    return false;
}

// JSON output
function json_output($type = 'error', $message = null, $data = array())
{
    $output = array(
        'error' => true,
        'success' => false,
        'message' => '',
    );

    if ($type == 'success') {
        $output['error'] = false;
        $output['success'] = true;
    } else {
        $output['message'] = 'An error occurred while processing your request. Please try again.';
    }

    if (!is_null($message)) {
        $output['message'] = $message;
    }

    if (is_array($data) && $data) {
        $output = array_merge($output, $data);
    }

    return $output;
}

// JSON response
function json_response($array = null)
{
    header('Content-Type: application/json; charset=utf-8');

    if (is_null($array)) {
        $array = json_output('error');
    }

    echo json_encode($array);
}

// Translation
function _t($key, $vars = array(), $filename = 'general')
{
    $filename = trim($filename);
    $filename_ext = substr($filename, -4);
    $language_code = Libs\Language::currentLanguage('code');

    if (strtolower($filename_ext) == '.php') {
        $file = TRANSLATIONS_PATH . $language_code . '/' . $filename;
    } else {
        $file = TRANSLATIONS_PATH . $language_code . '/' . $filename . '.php';
    }

    if (is_file($file)) {
        include $file;
        $string = array_value($translation, $key);

        return Libs\Parser::parse($string, $vars);
    }
}
