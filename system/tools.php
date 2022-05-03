<?php

// Autoload files
function autoload_files($folder, $ext = '*.php')
{
    if (is_dir($folder)) {
        foreach (glob($folder . '/' . $ext) as $filename) {
            include $filename;
        }
    }
}

// Debug code
function debug($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

// Get config
function get_config($key = null)
{
    $config = include HOME_PATH . 'config.inc.php';
    return (!is_null($key) && $key) ? array_value($config, $key) : array();
}

// Get configs
function get_configs()
{
    return include HOME_PATH . 'config.inc.php';
}

// Get json file
function get_json_file($filename, $output = 'json')
{
    $json = null;
    $filename = trim($filename);
    $filename_ext = substr($filename, -6);

    if (strtolower($filename_ext) == '.json') {
        $file = JSON_PATH . $filename;
    } else {
        $file = JSON_PATH . $filename . '.json';
    }

    if (is_file($file)) {
        $json = file_get_contents($file);
    }

    if (!is_null($json) && $json) {
        $data = $json;

        switch ($output) {
            case 'array':
                $data = json_decode($json, true);
                break;
            case 'object':
                $data = json_decode($json);
                break;
        }

        return $data;
    }
}

// Include view
function get_view($file = false, $data = array(), $view = false)
{
    $inc = $file . '.php';

    if (is_file($inc)) {
        if ($data && is_array($data)) {
            extract($data);
        }

        if ($view) {
            ob_start();
            include $inc;
            return ob_get_clean();
        } else {
            include $inc;
        }
    }
}

// Delete dir
function rm_dir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);

        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rm_dir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }

        reset($objects);
        rmdir($dir);
    }
}

// Delete files in dir
function rm_files_in_dir($dir, $delete_self = false)
{
    if (is_dir($dir)) {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                rm_files_in_dir($file, true);
            } else {
                unlink($file);
            }
        }

        if ($delete_self) {
            rmdir($dir);
        }
    }
}

// Convert byte
function convert_bytes($bytes)
{
    $result = '0 B';

    $bytes = floatval($bytes);
    $sizes = array(
        0 => array(
            "UNIT" => "TB",
            "VALUE" => pow(1024, 4),
        ),
        1 => array(
            "UNIT" => "GB",
            "VALUE" => pow(1024, 3),
        ),
        2 => array(
            "UNIT" => "MB",
            "VALUE" => pow(1024, 2),
        ),
        3 => array(
            "UNIT" => "KB",
            "VALUE" => 1024,
        ),
        4 => array(
            "UNIT" => "B",
            "VALUE" => 1,
        ),
    );

    foreach ($sizes as $size) {
        if ($bytes >= $size["VALUE"]) {
            $result = $bytes / $size["VALUE"];
            $result = strval(round($result, 2)) . " " . $size["UNIT"];
            break;
        }
    }

    return $result;
}
