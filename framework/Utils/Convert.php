<?php

class Convert
{
    public static function toBoolean($value)
    {
        if ($value === null || is_bool($value)) {
            return $value;
        }
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public static function toInteger($value)
    {
        if ($value === null || is_integer($value)) {
            return $value;
        }
        return (integer)$value;
    }

    public static function toDouble($value)
    {
        if ($value === null || is_double($value)) {
            return $value;
        }
        return (double)$value;
    }
}