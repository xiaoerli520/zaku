<?php
require __DIR__ . '/Results/ResultVO.php';

class Bootstrap
{
    public static $mysql = null;

    public static function initMysql()
    {
        self::$mysql = new \Swoole\Database\MySQLi(Config::get("db"));
        self::$mysql->connect();
    }

    public static function getMysql()
    {
        if (self::$mysql !== null) {
            self::initMysql();
        }
        return self::$mysql;
    }

    public static function initConfig()
    {
        Config::loadConf(__DIR__ . '/confs/framework.ini', "framework");
        Config::loadConf(__DIR__ . '/confs/config.ini', "app");
        Config::loadConf(__DIR__ . '/confs/database.ini', "db");
    }

    public static function initLogger()
    {
        Logger::setPath("/tmp/zaku");
        Logger::setLevel(Logger::WARN);
    }

    public static function errHandler()
    {
        var_dump(error_get_last());
    }

}