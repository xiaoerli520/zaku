<?php

class Middleware
{
    private static $before = [];
    private static $after = [];

    public static function setBefore(callable $beforeMiddle)
    {
        array_push(self::$before, $beforeMiddle);
    }

    public static function setAfter(callable $afterMiddle)
    {
        array_push(self::$after, $afterMiddle);
    }

    public function executeBefore(Request $request, Response $response)
    {
        call_user_func_array(self::$before, [$request]);
    }

    public function executeAfter(Request $request, Response $response)
    {
        call_user_func_array(self::$after, [$response]);
    }


}