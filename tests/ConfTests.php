<?php

use PHPUnit\Framework\TestCase;

class ConfTests extends TestCase
{
    public static $path = __DIR__ . '/../application/confs/config.ini';

    public function testConfig()
    {
        Config::loadConf(self::$path, "app");
        $res = Config::get('app');
        $this -> assertEquals($res['name'], "value");
        $res1 = Config::get("abc");
        $this -> assertEquals($res1, false);
        $res2 = Config::get("");
        $this -> assertEquals($res2, false);

        $res3 = Config::get("app.name");
        $this -> assertEquals($res3, "value");
        $res4 = Config::get("app.name777");
        $this -> assertEquals($res4, false);

        Config::set("asd", ['a'=> 1, 'b' => 2]);
        Config::set("asd.c", 3);
        $res5 = Config::get("asd");
        $this -> assertEquals($res5['c'], 3);
    }

    public function testErrors()
    {
        try {
            Config::loadConf("", "");
        } catch (\Exception $e) {
            $this -> assertInstanceOf(ConfFileNotValid::class, $e);
        }

        try {
            Config::loadConf("asdf", "asd");
        } catch (\Exception $e) {
            $this -> assertInstanceOf(ConfFileNotValid::class, $e);
        }

        try {
            Config::loadConf("asdf", "");
        } catch (\Exception $e) {
            $this -> assertInstanceOf(ConfFileNotValid::class, $e);
        }
    }
}