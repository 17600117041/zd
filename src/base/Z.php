<?php

namespace base;

use base\exception\Exception;
use base\exception\UnknownClassException;

class Z
{
    public static $classMap = [];

    /**
     * @var \base\web\Application
     */
    public static $app;

    /**
     * @var \base\Container
     */
    protected static $container;

    /**
     * @param $className
     * @throws UnknownClassException
     */
    public static function autoload($className)
    {
        if (isset(static::$classMap[$className])) {
            $classFile = static::$classMap[$className];
        } elseif (strpos($className, '\\') !== false) {
            $classFile = str_replace('\\', '/', $className) . '.php';
            if ($classFile === false || !is_file($classFile)) {
                return;
            }
        } else {
            return;
        }
        include $classFile;
        
        if (KO_DEBUG && !class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new UnknownClassException("Unable to find '$className' in file: " . $classFile . "Namespace missing?" );
        }
    }

    /**
     * @param $type
     * @param array $params
     * @return mixed|object
     * @throws Exception
     */
    public function createObject($type, $params = [])
    {
        if (is_string($type)) {
            return static::$container->get($type, $params);
        } elseif (is_array($type) && isset($type['class'])) {
            $class = $type['class'];
            unset($type['class']);
            return static::$container->get($class, $params);
        } elseif (is_array($type)) {
            throw new Exception('Object configuration must be an array containing a "class" element');
        }
        throw new Exception('nonsupport configuration type' . gettype($type));
    }
}