<?php

require './framework/main.php';

Config::loadConf(__DIR__ . '/application/confs/framework.ini', "framework");
Config::loadConf(__DIR__ . '/application/confs/config.ini', "app");
Config::loadConf(__DIR__ . '/application/confs/database.ini', "db");
Logger::setPath("/tmp/zaku");
Logger::setLevel(Logger::WARN);

$router = Router::getInstance();
$dispatcher = Dispatcher::getInstance();

$mysql = new \Swoole\Database\MySQLi(Config::get("db"));
$mysql->connect();

Logger::error("asdf");

$http = new swoole_http_server("0.0.0.0", 9501, SWOOLE_BASE);
$http->set(Config::get("framework"));

function main(swoole_http_request $request, swoole_http_response $response)
{
    global $router, $dispatcher;
    try {
        $req      = new Request($request);
        $resp     = new Response($response);
        $r        = $router->find($req->url());
        $response = $dispatcher->dispatch($r['c'], $r['m'], $req, $resp);
        $response -> getRequest() -> end();
    } catch (\Exception $e) {
        echo $e->getTraceAsString() . PHP_EOL;
        $response->getRequest() -> end("500 Server Error :: " . $e->getTraceAsString());
    }
}

function errHandle()
{
    var_dump(error_get_last());
}

$http->on('request', 'main');

register_shutdown_function('errHandle');

$http->start();