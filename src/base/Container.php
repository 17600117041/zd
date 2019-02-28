<?php
/**
 * Created by PhpStorm.
 * User: zhangda
 * Date: 2019/2/28
 * Time: 上午10:47
 */

namespace base;


use base\exception\Exception;

class Container extends Component
{
    private $_singletons = [];

    /**
     * @param $class
     * @param array $params
     * @return mixed|object
     * @throws Exception
     */
    public function get($class, $params = [])
    {
        if (isset($this->_singletons[$class])) {
            return $this->_singletons[$class];
        } elseif(!isset($this->_singletons[$class])) {
            return $this->build($class, $params);
        }
    }

    /**
     * @param $class
     * @param $params
     * @return mixed|object
     * @throws Exception
     */
    protected function build($class, $params)
    {
        /** @var $reflection \ReflectionClass */
        list($reflection, $dependence) = $this->getDependence($class);

        if (!$reflection ->isInstantiable()) {
            throw new Exception('no instantiable: ' . $reflection->getName());
        }

        if ($dependence) {
            if ($reflection->isSubclassOf(ObjectZ::class)) {
                return $reflection->newInstanceArgs([$params]);
            }
            return $reflection->newInstanceArgs([$params]);
        } else {
            $this->_singletons[$class] = $reflection->newInstanceArgs([$params]);
            return $this->_singletons[$class];
        }
    }

    /**
     * @param $class
     * @return array
     * @throws Exception
     */
    protected function getDependence($class)
    {
        $dependence = false;
        try {
            $reflection = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new Exception('Failed to instantiate component or class "' . $class .'"', 0, $e);
        }

        $constructor = $reflection->getConstructor();
        if ($constructor !== null && $constructor->getParameters()) {
            $dependence = true;
        }

        return [$reflection, $dependence];
    }
}