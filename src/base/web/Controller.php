<?php

namespace base\web;

use base\ObjectZ;

class Controller extends ObjectZ
{
    protected function response($data, $code = 0)
    {
        if ($data === []) {
            $data = new \StdClass;
        }
        return [
            'code' => $code,
            'body' => $data,
        ];
    }
}