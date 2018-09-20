<?php

class Index_Model
{
    public function test()
    {
        global $mysql;
        $res = $mysql -> query("select * from `bind_code`") -> fetchall();
        return $res;
    }
}