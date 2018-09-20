<?php

class ConfFileNotValid extends \Exception {}
class ConfNotInited extends \Exception {}
class ConfNotFound extends \Exception {}
class ConfParamError extends \Exception {}

class Config
{
    const INI = 1;

    const JSON = 2;

    // todo init config by type
    private static $_type = self::INI;

    private static $_conf = [];

    private static $_inst = null;

    private static $_inited = false;

    private function __construct()
    {
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

    /**
     * Method  loadConf
     * if the conf ini parse failed will return false only
     *
     * @author
     * @static
     *
     * @param string $path
     * @param string $prefix
     *
     * @throws ConfFileNotValid
     */
    public static function loadConf(string $path, string $prefix)
    {
        if (empty($path) || empty($prefix) || !file_exists($path)) {
            throw new ConfFileNotValid($path ." not found");
        }
        self::$_conf[$prefix] = parse_ini_file($path);
        self::$_inited = true;
    }

    /**
     * Method  parseKey
     *
     * import should be "a.b"
     *
     * @author suchong
     * @static
     *
     * @param string $key
     * @throws ConfNotFound
     * @return array
     */
    private static function parseKey(string $key)
    {
        $c = explode('.', $key);
        if (count($c) === 1) {
            return ['p' => $key, 'k' => '*'];
        } else if (count($c) < 1) {
            throw new ConfNotFound();
        }
        return ['p' => $c[0], 'k' => $c[1]];
    }

    public static function get(string $key)
    {
        $c = self::parseKey($key);
        if (self::$_inited === false) {
            throw new ConfNotInited();
        }
        if ($c['k'] === '*') {
            return self::$_conf[$c['p']] ?? false ;
        }
        return self::$_conf[$c['p']][$c['k']] ?? false;
    }

    /**
     * Method  set LifeCycle only Per Request but swoole is permanent
     *
     * @author
     * @static
     *
     * @param string $key
     * @param string $val
     *
     * @throws ConfParamError
     * @throws ConfNotFound
     */
    public static function set(string $key, $val)
    {
        if (empty($key) || empty($val)) {
            throw new ConfParamError();
        }
        $c = self::parseKey($key);
        if ($c['k'] == '*') {
            self::$_conf[$key] = $val;
            return;
        }
        self::$_conf[$c['p']][$c['k']] = $val;
    }
}
