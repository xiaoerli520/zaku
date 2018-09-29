<?php

class Mock
{
    public function beforeAction(Request $request, Response $response)
    {

    }

    public function afterAction(Request $request, Response $response)
    {

    }

    public function ActionDetail(Request $request, Response $response)
    {
        $response -> body(json_encode(['title' => 'test title', 'content' => 'test content']));
        return $response;
    }
}