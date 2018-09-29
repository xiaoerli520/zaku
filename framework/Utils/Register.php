<?php

class KeyNotValid extends \Exception {}

class Register
{
    private static $globals_var = [];

    public static function set(string $key, $value)
    {
        if (empty($key)) {
            throw new KeyNotValid();
        }
        self::$globals_var[$key] = $value;
    }

    public static function get(string $key)
    {
        if (empty($key)) {
            throw new KeyNotValid();
        }
        return self::$globals_var[$key] ?? null;
    }

}