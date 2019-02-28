<?php

namespace base\exception;

class InvalidCallException extends \BadMethodCallException
{
    public function getName()
    {
        return "Invalid Call";
    }
}