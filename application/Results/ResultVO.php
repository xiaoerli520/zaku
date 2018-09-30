<?php

trait ResultVO
{
    public static function success($data, $msg = '')
    {
        return json_encode([
            'code' => 0,
            'msg' => $msg,
            'data' => $data
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public static function fail($code, $data, $msg = '')
    {
        return json_encode([
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ]);
    }
}