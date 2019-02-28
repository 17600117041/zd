<?php
/**
 * Created by PhpStorm.
 * User: zhangda
 * Date: 2019/2/28
 * Time: 上午11:08
 */

namespace base\web;


use base\Container;
use base\ObjectZ;

class Base extends ObjectZ
{
    /** @var Container */
    public $container;

    protected $actionName     = 'index';
    protected $controllerName = 'index';

    protected function run()
    {

    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    protected function getControllerActionName()
    {
        $controllerName = $this->controllerName;
        $actionName     = $this->actionName;

        try {
            $controllerName = ucfirst($controllerName);
            $controller     = $this->container->get("\\controller\\{$controllerName}Controller");
        } catch (\Exception $e) {
            return [null, null];
        }
        try {
            $action = new \ReflectionMethod($controller, 'action' . ucfirst($actionName));
        } catch (\Exception $e) {
            return [$controller, null];
        }
        return [$controller, $action];
    }
}