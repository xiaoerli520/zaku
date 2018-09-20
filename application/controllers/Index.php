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
        sleep(3);
        return json_encode(Config::get("app"));
    }
}