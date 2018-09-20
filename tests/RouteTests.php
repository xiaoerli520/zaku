<?php

use PHPUnit\Framework\TestCase;

class RouteTests extends TestCase
{

    public function testSimple()
    {
        $router = Router::getInstance() -> setMode(Router::MODE_SIMPLE);
        $res = $router -> findSimple("asc/asf");
        $this -> assertEquals($res['c'], "asc");
        $this -> assertEquals($res['m'], "asf");
        $res = $router -> findSimple("asc/");
        $this -> assertEquals($res['c'], "asc");
        $this -> assertEquals($res['m'], "index");
        try{
            $res = $router -> findSimple("/asf");
            print_r($res);
        } catch (\Exception $e) {
            $this -> assertInstanceOf(RoutePathNotValid::class, $e);
        }
        try{
            $res = $router -> findSimple("/");
            print_r($res);
        }catch (\Exception $e){
            $this -> assertInstanceOf(RoutePathNotValid::class, $e);
        }
        try {
            $res = $router -> findSimple("");
            print_r($res);
        } catch (\Exception $e) {
            $this -> assertInstanceOf(RoutePathNotValid::class, $e);
        }
        try {
            $res = $router -> findSimple(null);
            print_r($res);
        } catch (\Throwable $e) {
        }
        try {
            $res = $router -> findSimple(777);
            print_r($res);
        } catch (\Throwable $e) {
        }
    }

    public function testMap()
    {
        $router = Router::getInstance()->setMode(Router::MODE_MAP);

        $this -> assertEquals($router -> getMode(), Router::MODE_MAP);

        $r1 = new MapRouterUnit("asc/asm", "asc", "asm");
        $r2 = new MapRouterUnit("asc/index", "asc", "");
        try {
            $r3 = new MapRouterUnit("", "asc", "asm");
        } catch (\Exception $e) {
            $this -> assertInstanceOf(RoutePathNotValid::class, $e);
        }
        try {
            $r4 = new MapRouterUnit("asc/asm", "", "asm");
        } catch (\Exception $e) {
            $this -> assertInstanceOf(RoutePathNotValid::class, $e);
        }
        try {
            $r5 = new MapRouterUnit("asc/asm", "asc", "");
        } catch (\Exception $e) {
            $this -> assertInstanceOf(RoutePathNotValid::class, $e);
        }

//        $router -> addMap($r1) -> addMap($r2);
        $router -> addMaps($r1, $r2);
        $this -> assertEquals($router -> findMap("asc/asm")['c'], 'asc');
        $this -> assertEquals($router -> findMap("asc/asm")['m'], 'asm');
        $this -> assertEquals($router -> findMap("asc/index")['m'], 'Base');
    }

}