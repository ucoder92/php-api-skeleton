<?php

/**
 * Language
 *
 * @package     PHP Skeleton
 * @author      Ulugbek Nuriddinov <ucoder92@gmail.com>
 * @link        https://github.com/ucoder92/php-api-skeleton
 * @since       1.0.0
 */

namespace Libs;

class Language
{
    private static $languages = null;

    /**
     * Get active languages
     *
     * @return array
     */
    public static function activeLanguages()
    {
        $array = array();
        $json = self::getLanguages();

        if ($json) {
            foreach ($json as $key => $item) {
                $is_active = array_value($item, 'active');

                if ($is_active) {
                    $array[$key] = $item;
                }
            }
        }

        return $array;
    }

    /**
     * Get current language
     *
     * @return array
     */
    public static function currentLanguage($field = null)
    {
        $output = array();
        $default = get_config('default_language');
        $array = self::get(input_get('lang', $default));

        if ($array) {
            $output = $array;
        } else {
            $languages = self::activeLanguages();
            $first = array_key_first($languages);

            $output = array_value($languages, $first);
        }

        if (!is_null($field)) {
            return array_value($output, $field);
        }

        return $output;
    }

    /**
     * Get default language
     *
     * @return array
     */
    public static function defaultLanguage()
    {
        $lang = get_config('default_language');
        return $lang ? self::get($lang) : array();
    }

    /**
     * Get language by key
     *
     * @param string $lang
     * @return array
     */
    public static function get($lang)
    {
        $json = self::getLanguages();
        $language = array_value($json, $lang);
        $is_active = array_value($language, 'active');

        return $is_active ? $language : array();
    }

    /**
     * Get languages
     *
     * @return array
     */
    public static function getLanguages()
    {
        $languages = array();

        if (self::$languages) {
            $languages = self::$languages;
        } else {
            $languages = get_json_file('languages', 'array');
            self::$languages = $languages;
        }

        return $languages;
    }
}
