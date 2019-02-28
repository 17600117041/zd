<?php
/**
 * Created by PhpStorm.
 * User: zhangda
 * Date: 2019/2/28
 * Time: 上午10:01
 */

namespace base\exception;


class UnknownPropertyException extends Exception
{
    public function getName()
    {
        return 'Unknown Property';
    }
}