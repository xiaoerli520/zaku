<?php

class Index
{
    public function ActionIndex(Request $request)
    {
        $IndexModel = new Index_Model();
        $IndexModel -> test();
        return $request -> url().$IndexModel -> test();
    }

    public function ActionTest()
    {
        return json_encode(Config::get("app"));
    }
}