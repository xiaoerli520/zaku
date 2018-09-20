<?php

require './framework/main.php';

$http = new swoole_http_server("0.0.0.0", 9501, SWOOLE_BASE);
$http->set([
    'worker_num' => 20,
    'dispatch_mode' => 1,
    'backlog' => 1024,
    'max_request' => 1000,
    'max_connection' => 10000,
    'daemonize' => 0
]);

Config::loadConf(__DIR__ . '/application/confs/config.ini', "app");
$router     = Router::getInstance();
$dispatcher = Dispatcher::getInstance();

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

function err()
{
    var_dump(error_get_last());
}

$http->on('request', 'main');

$http->on('WorkerError', 'err');

register_shutdown_function('err');

$http->start();