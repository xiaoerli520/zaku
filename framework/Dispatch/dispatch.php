<?php

/**
 * Class     Dispatcher
 *
 * dispatch request c => '', m => ''
 *
 * @author
 */
class DispatchNotFound extends \Exception {}

class Dispatcher
{
    private static $_inst = null;

    protected function __construct()
    {
        spl_autoload_register(function($class) {
            if (file_exists(__DIR__ . '/../../application/controllers/'.ucfirst($class).".php")) {
                include __DIR__ . '/../../application/controllers/'.ucfirst($class).".php";
            } else if (file_exists(__DIR__ . '/../../application/models/'.ucfirst($class).".php")) {
                include __DIR__ . '/../../application/models/'.ucfirst($class).".php";
            } else {
                throw new DispatchNotFound();
            }
        });
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (!(self::$_inst instanceof self)) {
            self::$_inst = new self;
        }
        return self::$_inst;
    }

    public function dispatch(string $c, string $m, Request $request, swoole_http_response $resp)
    {
        $c = ucfirst($c);
        $m = "Action".ucfirst($m);
        $ic = new $c();
        if (!method_exists($ic, $m)) {
            throw new DispatchNotFound();
        }
        $res = $ic -> $m($request, $resp);
        $resp -> write($res);
        return $resp;
    }
}