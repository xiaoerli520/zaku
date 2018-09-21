<?php

class Mock
{
    public function ActionDetail(Request $request, Response $response)
    {
        $response -> body(json_encode(['title' => 'test title', 'content' => 'test content']));
        return $response;
    }
}