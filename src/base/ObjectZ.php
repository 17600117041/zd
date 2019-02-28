<?php

namespace base;


use base\exception\InvalidCallException;
use base\exception\UnknownMethodException;
use base\exception\UnknownPropertyException;

class ObjectZ implements Configurable
{
    public function __construct($config = [])
    {
        if (!empty($config)) {
            Lib::configure($this, $config);
        }
        $this->init();

    }

    public static function className()
    {
        return get_called_class();
    }

    public function init()
    {

    }

    /**
     * @param $name
     * @return mixed the property name
     * @throws UnknownPropertyException
     * @see __set()
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this, 'set' . $name)) {
            throw new  InvalidCallException("Getting write-only property:" . get_class($this) . "::" . $name);
        }
        
        throw new UnknownPropertyException('Getting unknown property:' . get_class($this) . '::'. $name);
    }

    /**
     * @param $name
     * @param $value
     * @throws UnknownPropertyException if the property is not defined
     * @throws InvalidCallException if the property is read-only
     * @see __get()
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Setting Unknown property:' . get_class($this) . '::' . $name);
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        }

        return false;
    }

    /**
     * @param $name
     * @throws
     */
    public function __unset($name)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter(null);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Unsetting read-only property:' . get_class($this) . '::' . $name);
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @throws UnknownMethodException
     */
    public function __call($name, $arguments)
    {
        throw new UnknownMethodException('Calling unknown method: ' . get_class($this) . "::$name()");
    }

    public function hasProperty($name, $checkVars = true)
    {
        return $this->canGetProperty($name, $checkVars);
    }

    public function canGetProperty($name, $checkVars= true)
    {
        return method_exists($this, 'get' . $name) || $checkVars && property_exists($this, $name);
    }

    public function canSetProperty($name, $checkVars)
    {
        return method_exists($this, 'set' . $name) || $checkVars && property_exists($this, $name);
    }

    public function hasMethod($name)
    {
        return method_exists($this, $name);
    }


}