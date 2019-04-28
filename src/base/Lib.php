<?php

namespace base;

use base\exception\Exception;
use Mfw\Log\Runtime;

class Lib
{
    private static $fatalErrors = [
        E_ERROR,
        E_PARSE,
        E_CORE_ERROR,
        E_COMPILE_ERROR,
    ];

    public static function configure($object, $properties)
    {
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }
        return $object;
    }

    public static function shutdownHandle()
    {
        $error = error_get_last();
        if ($error !== null && in_array($error[type], self::$fatalErrors)) {
            Runtime::error([
                'type'   => $error['type'],
                'message' => $error['message'],
                'file'   => $error['file'],
                'line'   => $error['line'],
            ]);
        }
    }

    public static function sendError()
    {
        Z::$app->response->data = [
            'code' => 500,
            'body' => '服务器内部错误',
        ];
        Z::$app->response->setStatusCode(500);
        Z::$app->response->send();
    }

    /**
     * @param $errorNo
     * @param $errorStr
     * @param $errorFile
     * @param $errorLine
     * @param $errorMes
     */
    public static function errorHandler($errorNo, $errorStr, $errorFile, $errorLine, $errorMes)
    {
        if (!in_array($errorNo, self::$fatalErrors)) {
            return;
        }
        Runtime::error([
            'errorNo'  => $errorNo,
            'errorStr' => $errorStr,
            'file'     => $errorFile,
            'line'     => $errorLine,
            'message'  => $errorMes,
        ]);
        if (KO_DEBUG) {
            dump(func_get_args());
            debug_print_backtrace();
        } else {
            self::sendError();
        }
    }

    /**
     * @param \Exception $e
     */
    public static function exceptionHandler(\Exception $e)
    {
        Runtime::error([
            'errorNo'  => $e->getCode(),
            'errorStr' => 'Caught Exception' . $e->getMessage(),
            'file'     => $e->getFile(),
            'line'     => $e->getLine(),
            'message'  => $e->getTrace(),
        ]);
        if (KO_DEBUG) {
            dump($e);
            debug_print_backtrace();
        } else {
            if ($e instanceof Exception) {
                Z::$app->response->data = [
                    'code' => $e->getCode(),
                    'body' => $e->getMessage(),
                ];
                Z::$app->response->send();
            } else {
                self::sendError();
            }
        }
    }

    /**
     * @param $file
     * @param $line
     * @param $code
     * @throws Exception
     */
    public static function assertCallback($file, $line, $code)
    {
        if (KO_DEBUG) {
            dump(func_get_args());
            debug_print_backtrace();
        } else {
            $error = 'Assertion Failed';
            throw new Exception($error);
        }
    }
}