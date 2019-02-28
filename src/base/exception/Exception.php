<?php
/**
 * Created by PhpStorm.
 * User: zhangda
 * Date: 2019/2/28
 * Time: 上午10:00
 */

namespace base\exception;


class Exception extends \Exception
{
    public function getName()
    {
        return 'Exception';
    }
}