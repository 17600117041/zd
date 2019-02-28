<?php

namespace helper;

class ArrayHelper
{
    public static function getLegalIds(array $array)
    {
        $result = [];
        foreach ($array as $item) {
            if ($item <= 0 || !is_numeric($item)) {
                continue;
            }
            $result[] = (int)$item;
        }
        return $result;
    }

    public static function arrayAccess2Array($arrayAccess)
    {
        $result = [];
        $count  = $arrayAccess->count();
        for ($i = 0; $i < $count; $i++) {
            $result[] = $arrayAccess->offsetGet($i);
        }
        return $result;
    }


    public static function getValue($array, $key, $default = null)
    {
        if ($key instanceof \Closure) {
            return $key($array, $default);
        }

        if (is_array($key)) {
            $lastKey = array_pop($key);
            foreach ($key as $keyPart) {
                $array = self::getValue($array, $keyPart);
            }
            $key = $lastKey;
        }

        if (is_array($array) && (isset($array[ $key ]) || array_key_exists($key, $array))) {
            return $array[ $key ];
        }

        if (($pos = strrpos($key, '.')) !== false) {
            $array = self::getValue($array, substr($key, 0, $pos), $default);
            $key   = substr($key, $pos + 1);
        }
        if (is_object($array)) {
            return $array->$key;
        } elseif (is_array($array)) {
            return (isset($array[ $key ]) || array_key_exists($key, $array)) ? $array[ $key ] : $default;
        }
        return $default;
    }

    public static function unique($array, $key)
    {
        $unique = [];
        foreach ($array as $item) {
            $uk = self::getValue($item, $key);
            if (!isset($unique[ $uk ])) {
                $unique[ $uk ] = $item;
            }
        }
        return array_values($unique);
    }

    public static function map($array, $from, $to, $group = null)
    {
        $result = [];
        foreach ($array as $element) {
            $key   = static::getValue($element, $from);
            $value = static::getValue($element, $to);
            if ($group !== null) {
                $result[ static::getValue($element, $group) ][ $key ] = $value;
            } else {
                $result[ $key ] = $value;
            }
        }

        return $result;
    }
}