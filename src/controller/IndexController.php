<?php

namespace controller;

use base\web\Controller;

class IndexController extends Controller
{
    public function actionIndex($id)
    {
        return $this->response([
            'message' => [
                'id' => $id,
            ],
        ]);
    }
}