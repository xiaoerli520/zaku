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
        sleep(10);
        return "777";
    }
}