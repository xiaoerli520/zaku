<?php

class Bootstrap
{
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