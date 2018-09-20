<?php

class RouteModeException extends \Exception
{
}

class RouteNotFoundException extends \Exception
{
    protected $path;

    public function __construct(string $path, string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this -> path = $path;
    }


    public function getPath()
    {
        return $this -> path;
    }
}

class RoutePathNotValid extends \Exception
{
}

class MapRouterUnit
{
    private $path = null;

    private $controller = null;

    private $method = null;

    /**
     * MapRouterUnit constructor.
     *
     * @param string $path "c/m"
     * @param string $controller
     * @param string $method
     * @throws RoutePathNotValid
     */
    public function __construct(string $path, string $controller, string $method = "index")
    {
        if (count(explode("/", $path)) != 2) {
            throw new RoutePathNotValid();
        }
        if (empty($controller)) {
            throw new RoutePathNotValid();
        }
        if (empty($method)) {
            $method = 'Base';
        }
        $this->path       = $path;
        $this->controller = $controller;
        $this->method     = $method;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function isValidate()
    {
        if (isset($this->path, $this->controller, $this->method)) {
            return true;
        }
        return false;
    }
}

class Router
{

    const MODE_MAP = 1;

    const MODE_SIMPLE = 2;

    const MODE_ARR = [
        self::MODE_MAP,
        self::MODE_SIMPLE,
    ];

    const SIMPLE_SEP = "/";

    private static $_instance = null;

    private $_mode = self::MODE_SIMPLE;

    private $_map = [];

    protected function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function setMode(int $mode)
    {
        if (!in_array($mode, self::MODE_ARR)) {
            throw new RouteModeException("RouteMode Not Exist");
        }
        $this->_mode = $mode;
        return $this;
    }

    public function getMode()
    {
        return $this -> _mode;
    }

    /**
     * Method  addMap
     *
     * @author
     *
     * @param MapRouterUnit $unit
     *
     * @throws RouteModeException
     * @return $this
     */
    public function addMap(MapRouterUnit $unit)
    {
        if ($this->_mode != self::MODE_MAP) {
            throw new RouteModeException("RouteMode Error");
        }
        // new route will overwrite old route
        $this->_map[$unit->getPath()] = $unit;
        return $this;
    }

    /**
     * Method  addMaps
     *
     * @author
     *
     * @param MapRouterUnit ...$units
     *
     * @throws RouteModeException
     * @return $this
     */
    public function addMaps(MapRouterUnit ...$units)
    {
        foreach ($units as $unit)
        {
            $this -> addMap($unit);
        }
        return $this;
    }

    /**
     * Method  findMap
     *
     * @author
     *
     * @param string $path
     *
     * @throws RouteNotFoundException
     * @return array
     */
    public function findMap(string $path)
    {
        if (!array_key_exists($path, $this -> _map)) {
            throw new RouteNotFoundException($path);
        }
        return [
            'c' => $this -> _map[$path] -> getController(),
            'm' => $this -> _map[$path] -> getMethod()
        ];
    }

    /**
     * Method  findSimple
     *
     * @author
     *
     * @param string $path "c/m"
     *
     * @throws RoutePathNotValid
     * @return array
     *
     * @todo favicon
     */
    public function findSimple(string $path)
    {
        $pathArr = explode(self::SIMPLE_SEP, $path);
        if (count($pathArr) < 1) {
            throw new RoutePathNotValid();
        }
        if (empty($pathArr[0])) {
            throw new RoutePathNotValid();
        }
        if (empty($pathArr[1])) {
            $pathArr[1] = 'Base';
        }
        return [
            'c' => $pathArr[0],
            'm' => $pathArr[1]
        ];
    }

    public function find(string $path)
    {
        switch ($this -> _mode) {
            case self::MODE_MAP:
                return $this -> findMap($path);
                break;
            case self::MODE_SIMPLE:
                return $this -> findSimple($path);
                break;
            default:
                return $this -> findSimple($path);
        }

    }
}