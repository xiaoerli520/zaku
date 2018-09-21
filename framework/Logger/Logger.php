<?php

class InvalidLevel extends \Exception {}
class InvalidPath extends \Exception {}
class LogPathFail extends \Exception {}
class InvalidLogFormat extends \Exception {}

class Logger
{
    const DEBUG = 0;
    const INFO = 1;
    const WARN = 2;
    const ERROR = 3;
    const DEFAULT_FORMAT = "%s : %s : %s"; // date where what

    protected static $_inst = null;

    private static $_path = null;

    private static $_level = self::DEBUG;

    private static $_format = self::DEFAULT_FORMAT;

    protected function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if(!(self::$_inst instanceof self)) {
            self::$_inst = new self;
        }
        return self::$_inst;
    }

    public static function setLevel(int $level = self::DEBUG)
    {
        if (!in_array($level, [self::DEBUG, self::INFO, self::WARN, self::ERROR])) {
            throw new InvalidLevel();
        }
        self::$_level = $level;
    }

    public static function setPath(string $path = null)
    {
        if (empty($path)) {
            throw new InvalidPath();
        }
        self::$_path = $path;

        self::logdir();
    }

    public static function setFormat(string $format)
    {
        if (empty($format)) {
            throw new InvalidLogFormat();
        }
        self::$_format = $format;
    }

    private static function logdir()
    {
        if (empty(self::$_path)) {
            throw new InvalidPath();
        }
        try {
            if (!is_dir(self::$_path)) {
                mkdir(self::$_path, 0755, true);
            }
        } catch (\Exception $e) {
            throw new LogPathFail();
        }
    }

    private static function shouldLog($level)
    {
        if ($level >= self::$_level) {
            return true;
        }
        return false;
    }

    public static function debug(...$contents)
    {
        if (!self::shouldLog(0)) {
            return true;
        }
        try {
            file_put_contents(self::$_path."/debug-".date("Y-m-d").".log", "[".date("Y-m-d H:i:s")."] ".implode(" , ", $contents).PHP_EOL, FILE_APPEND);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function info(...$contents)
    {
        if (!self::shouldLog(1)) {
            return true;
        }
        try {
            file_put_contents(self::$_path."/info-".date("Y-m-d").".log", "[".date("Y-m-d H:i:s")."] ".implode(" , ", $contents).PHP_EOL, FILE_APPEND);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function warn(...$contents)
    {
        if (!self::shouldLog(2)) {
            return true;
        }
        try {
            file_put_contents(self::$_path."/warn-".date("Y-m-d").".log", "[".date("Y-m-d H:i:s")."] ".implode(" , ", $contents).PHP_EOL, FILE_APPEND);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function error(...$contents)
    {
        if (!self::shouldLog(3)) {
            return true;
        }
        try {
            file_put_contents(self::$_path."/error-".date("Y-m-d").".log", "[".date("Y-m-d H:i:s")."] ".implode(" , ", $contents).PHP_EOL, FILE_APPEND);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}