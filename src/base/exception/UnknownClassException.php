<?php
/**
 * Created by PhpStorm.
 * User: zhangda
 * Date: 2019/2/28
 * Time: 上午10:43
 */

namespace base\exception;


class UnknownClassException extends Exception
{
    public function getName()
    {
        return 'Unknown Class';
    }
}