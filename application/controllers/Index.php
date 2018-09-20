<?php

class Index
{
    public function ActionIndex(Request $request, Response $response)
    {
        $IndexModel = new Index_Model();
        $res = $IndexModel -> test();
        return $response -> body(json_encode($res));
    }

    public function ActionTest()
    {
        return json_encode(Config::get("app"));
    }

    public function ActionResp(Request $request, Response $response)
    {
        $response -> body("777");
        return $response;
    }
}