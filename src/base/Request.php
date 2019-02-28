<?php

namespace base;


use helper\ArrayHelper;

/**
 * Class Request
 * @package base
 * @property bool isGet
 * @property bool isPost
 * @property string method
 * @property string script
 * @property string requestUri
 */
class Request extends Component
{
    private $_get;
    private $_post;

    public function setData(array $data)
    {
        list($this->_get, $this->_post) = $data;
    }

    public function getIsGet()
    {
        return Z::$app->server->get('REQUEST_METHOD') === 'GET';
    }

    public function getIsPost()
    {
        return Z::$app->server->get('REQUEST_METHOD') === 'POST';
    }

    public function getMethod()
    {
        return Z::$app->server->get('REQUEST_METHOD') ?: 'GET';
    }

    public function getScript()
    {
        return Z::$app->server->get('SCRIPT_FILENAME');
    }

    public function getRequestUri()
    {
        return Z::$app->server->get('REQUEST_URI');
    }

    public function getParams($key, $default = null)
    {
        if (($params = ArrayHelper::getValue($this->_post, $key, $default)) === null) {
            $data = ArrayHelper::getValue($this->_get, $key, $default);
        } else {
            $data = $params;
        }
        return $data;
    }
}