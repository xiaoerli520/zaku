<?php

require './framework/main.php';
require './application/Bootstrap.php';

Bootstrap::initConfig();
Bootstrap::initLogger();
Bootstrap::initMysql();
Bootstrap::initRedis("127.0.0.1", 6379);

$router     = Router::getInstance();
$dispatcher = Dispatcher::getInstance();
$mysql = Bootstrap::getMysql();

$server = new swoole_http_server("0.0.0.0", 9501, SWOOLE_BASE);
$server->set(Config::get("framework"));

function main(swoole_http_request $request, swoole_http_response $response)
{
    global $router, $dispatcher;
    try {
        $req      = new Request($request);
        $resp     = new Response($response);
        $r        = $router->find($req->url());
        $response = $dispatcher->dispatch($r['c'], $r['m'], $req, $resp);
        $response->getResponse()->end();
    } catch (\Exception $e) {
        echo $e->getTraceAsString() . PHP_EOL;
        $response->getResponse()->end("500 Server Error :: <br/>" . $e->getTraceAsString());
    }
}

function onStart()
{
    echo "Zaku Server Start Successfully".PHP_EOL;
}

$server->on('request', 'main');

register_shutdown_function('Bootstrap::errHandler');

onStart();

$server->start();