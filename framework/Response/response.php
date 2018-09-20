<?php

class Response
{
    private $_resp = null;

    public function __construct(swoole_http_response $response)
    {
        $this -> _resp = $response;
    }

    public function header(string $key, string $val)
    {
        $this -> _resp -> header($key, $val);
        return $this;
    }

    public function status(int $code)
    {
        $this -> _resp -> status($code);
        return $this;
    }

    public function cookie(string $key, string $val, int $expire = 3600, string $path = '/')
    {
        $this -> _resp -> cookie($key, $val, $expire, $path);
        return $this;
    }

    public function redirect(string $url, int $code)
    {
        $this -> _resp -> redirect($url, $code);
    }

    public function body(string $data)
    {
        $this -> _resp -> write($data);
        return $this;
    }

    public function end(string $content = '')
    {
        $this -> _resp -> end($content);
    }
}