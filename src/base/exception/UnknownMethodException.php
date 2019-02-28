<?php
/**
 * Created by PhpStorm.
 * User: zhangda
 * Date: 2019/2/28
 * Time: 上午10:29
 */

namespace base\exception;


class UnknownMethodException extends Exception
{
    public function getName()
    {
        return 'Unknown Method';
    }
}