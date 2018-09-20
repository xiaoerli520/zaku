<?php

use framework\URL;

class Request
{
    private $_reuqest = null;

    public function __construct(swoole_http_request $request)
    {
        $this -> _reuqest = $request;
    }

    public function isPost()
    {
        return ($this -> _reuqest -> server['request_method'] == URL::POST) ? true : false;
    }

    public function isGet()
    {
        return ($this -> _reuqest -> server['request_method'] == URL::GET) ? true : false;
    }

    public function isPut()
    {
        return ($this -> _reuqest -> server['request_method'] == URL::PUT) ? true : false;
    }

    public function isPatch()
    {
        return ($this -> _reuqest -> server['request_method'] == URL::PATCH) ? true : false;
    }

    public function isDelete()
    {
        return ($this -> _reuqest -> server['request_method'] == URL::DELETE) ? true : false;
    }

    public function Method()
    {
        return $this -> _reuqest -> server['request_method'];
    }

    public function query(string $key)
    {
        return $this -> _reuqest -> get[$key] ?? false;
    }

    public function queries()
    {
        return $this -> _reuqest -> get;
    }

    public function param(string $key)
    {
        return $this -> _reuqest -> post[$key] ?? false;
    }

    public function params()
    {
        return $this -> _reuqest -> post;
    }

    public function cookie(string $key)
    {
        return $this -> _reuqest -> cookie[$key] ?? false;
    }

    public function cookies()
    {
        return $this -> _reuqest -> cookie;
    }

    public function header(string $key)
    {
        return $this -> _reuqest -> header[$key] ?? false;
    }

    public function headers()
    {
        return $this -> _reuqest -> header;
    }

    public function servers()
    {
        return $this -> _reuqest -> server;
    }

    public function file()
    {
        return $this -> _reuqest -> files;
    }

    public function url()
    {
        return ltrim($this -> _reuqest -> server['request_uri'], "/");
    }



}
