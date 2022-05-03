<?php

/**
 * Parser
 *
 * @package     PHP Skeleton
 * @author      Ulugbek Nuriddinov <ucoder92@gmail.com>
 * @link        https://github.com/ucoder92/php-api-skeleton
 * @since       1.0.0
 */

namespace Libs;

class Parser
{
    private static $html = '';
    private static $vars = array();
    private static $matches = array();

    /**
     * Parse string
     *
     * @param string $string
     * @param array $vars
     * @return string
     */
    public static function parse($string, $vars = [])
    {
        self::matchVars($string);
        self::$html = $string;

        if (self::$matches) {
            $configs = get_configs();

            if ($configs) {
                unset($configs['db']);
                unset($configs['smtp']);
                unset($configs['session']);
                unset($configs['security']);

                self::mergeVars($configs, true);
            }

            if (is_array($vars) && $vars) {
                self::mergeVars($vars, false);
            }

            self::filterHtml();
        }

        return self::$html;
    }

    /**
     * Parse file
     *
     * @param string $file_name
     * @param array $vars
     * @return string
     */
    public static function parseFile($file_name, $vars = [])
    {
        $output = '';
        $file = HOME_PATH . $file_name;

        if (is_file($file)) {
            $html = file_get_contents($file);
            $output = $html ? self::parse($html, $vars) : '';
        }

        return $output;
    }

    /**
     * Parse inc file
     *
     * @param string $file_name
     * @param array $vars
     * @return string
     */
    public static function parseIncFile($file_name, $vars = [])
    {
        $output = '';
        $file = INC_PATH . $file_name;

        if (is_file($file)) {
            $html = file_get_contents($file);
            $output = $html ? self::parse($html, $vars) : '';
        }

        return $output;
    }

    /**
     * Filter HTML
     *
     * @return void
     */
    private static function filterHtml()
    {
        if (self::$html && self::$matches) {
            $find = array();
            $replace = array();

            foreach (self::$matches as $key => $item) {
                $schar = substr($item, 0, 4);

                if ('fun.' == $schar) {
                    $func = substr($item, 4);
                    $value = self::runEval($func);
                } elseif ('var.' == $schar) {
                    $variable = substr($item, 4);
                    $value = self::runEval($variable);
                } else {
                    $value = array_value(self::$vars, $item, '');
                }

                $find[] = $key;
                $replace[] = is_string($value) ? $value : '';
            }

            self::$html = str_replace($find, $replace, self::$html);
        }
    }

    /**
     * Merge variables
     *
     * @param array $vars
     * @param boolean $match
     * @return void
     */
    private static function mergeVars($vars, $match = false)
    {
        if (is_array($vars) && $vars) {
            if ($match) {
                foreach ($vars as &$value) {
                    self::matchVars($value);
                }
            }

            self::$vars = array_merge(self::$vars, $vars);
        }
    }

    /**
     * Match variables
     *
     * @param string $string
     * @return void
     */
    private static function matchVars($string)
    {
        $array = array();
        preg_match_all("/{{.+?}}/", $string, $matches);

        if (array_value($matches, 0)) {
            foreach ($matches[0] as $value) {
                $key = trim($value);
                $key = substr($key, 2);
                $key = substr($key, 0, -2);
                $key = trim($key);
                $array[$value] = $key;
            }
        }

        if ($array) {
            self::$matches = array_merge(self::$matches, $array);
        }
    }

    /**
     * Eval
     *
     * @param string $str
     * @return string
     */
    private static function runEval($str)
    {
        ob_start();
        eval("echo $str;");
        return ob_get_clean();
    }
}
