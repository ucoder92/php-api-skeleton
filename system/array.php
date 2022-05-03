<?php
// Get array value
function array_value($array, $key, $default = false)
{
    if (isset($array[$key]) && $array[$key]) {
        return $array[$key];
    }

    return $default;
}

// Filters array by given condition
function filter_array($array, $where, $single_item = false)
{
    $result = [];

    foreach ($array as $row) {
        $condition = true;

        if (is_null($row) || empty($row)) {
            $condition  = false;
        } else {
            foreach ($where as $field => $value) {
                if ($row[$field] != $value) {
                    $condition  = false;
                    break;
                }
            }
        }

        if ($condition) {
            $result[] = $row;
        }
    }

    if ($result && $single_item) {
        return array_values($result)[0];
    }

    return $result;
}

// Filters array by given fields
function filter_array_fields($array, $fields)
{
    $result = [];

    foreach ($array as $item) {
        if (is_string($fields)) {
            $result[] = array_value($item, $fields);
        } elseif (is_array($fields)) {
            $field_item = array();

            foreach ($fields as $field) {
                if (isset($item[$field])) {
                    $field_item[$field] = $item[$field];
                }
            }

            $result[] = $field_item;
        }
    }

    return $result;
}

// Array sort by key
function array_sort_by_key(&$array, $key)
{
    $sorter = array();
    $ret = array();
    reset($array);

    foreach ($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }

    asort($sorter);

    foreach ($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }

    $array = $ret;
    return $array;
}
