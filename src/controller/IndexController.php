<?php

namespace controller;

use base\web\Controller;

class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->response([
            'message' => 'test',
        ]);
    }
}