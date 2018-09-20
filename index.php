<?php

require './framework/main.php';

Config::loadConf(__DIR__ . '/application/confs/framework.ini', "framework");
Config::loadConf(__DIR__ . '/application/confs/config.ini', "app");
$router     = Router::getInstance();
$dispatcher = Dispatcher::getInstance();

$http = new swoole_http_server("0.0.0.0", 9501, SWOOLE_BASE);
$http->set(Config::get("framework"));

function main(swoole_http_request $request, swoole_http_response $response)
{
    global $router, $dispatcher;
    try {
        $req      = new Request($request);
        $r        = $router->find($req->url());
        $response = $dispatcher->dispatch($r['c'], $r['m'], $req, $response);
        $response->end();
    } catch (\Exception $e) {
        echo $e -> getTraceAsString().PHP_EOL;
        $response->end("500 Server Error :: ".$e -> getTraceAsString());
    }
}

function errHandle()
{
    var_dump(error_get_last());
}

$http->on('request', 'main');

register_shutdown_function('errHandle');

$http->start();