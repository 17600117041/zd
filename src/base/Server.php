<?php

namespace base;

use helper\ArrayHelper;

class Server extends Component
{
    private $_data;

    public function get($key, $default = null)
    {
        return ArrayHelper::getValue($this->_data, $key, $default);
    }

    public function setData(array $serverData)
    {
        $this->_data = $serverData;
    }
}