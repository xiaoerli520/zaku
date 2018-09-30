<?php

class Go
{
    use ResultVO;

    public function ActionIndex(Request $request, Response $response)
    {
        $model = new Go_Model();
        $res = $model -> getList($request->query('page') ?? 1, $request -> query('page_size') ?? 10);
        $response -> body(ResultVO::success($res));
        return $response;
    }

    public function ActionCreate(Request $request, Response $response)
    {
        $model = new Go_Model();
        if (!$request -> isPost()) {
            $response -> body(ResultVO::fail(-10000, [], "curr method not supported"));
            return $response;
        }
        if($model -> create($request -> param('title'), $request -> param('content'), $request -> param('tags'), $request -> param('refers'))) {
            $response -> body(ResultVO::success([]));
            return $response;
        } else {
            $response -> body(ResultVO::fail(-10001, [], "insert fail"));
            return $response;
        }
    }

    public function ActionDetail(Request $request, Response $response)
    {
        $model = new Go_Model();

        $detail = $model -> getDetail($request -> query('id'));
        $response -> body(ResultVO::success($detail));
        return $response;
    }

    public function ActionModify(Request $request, Response $response)
    {
        $model = new Go_Model();
        if (!$request -> isPost()) {
            $response -> body(ResultVO::fail(-10000, [], "method not supported"));
            return $response;
        }
        $result = $model -> modify($request->param('id'), $request->param('title'), $request->param('content'), $request -> param('tags'), $request->param('refers'));
        if ($result == false) {
            $response->body(ResultVO::fail(-10001, [], "update failed"));
            return $response;
        }
        $response->body(ResultVO::success([]));
        return $response;
    }

    public function ActionDelete(Request $request, Response $response)
    {
        $model = new Go_Model();
        $result = $model -> delete($request -> query('id'));
        if ($result == false) {
            $response -> body(ResultVO::fail(-10001, [], "delete failed"));
            return $response;
        }
        $response -> body(ResultVO::success([]));
        return $response;
    }
}