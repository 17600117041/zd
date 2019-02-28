<?php

namespace base;


use base\exception\InvalidCallException;

class Response extends Component
{
    public $data;
    public $version = '1.0.0';
    public $format  = self::FORMAT_JSON;

    private $_statusCode = 200;
    private $_statusText = '';
    private $_header     = [];
    private $_hasSend    = false;

    const FORMAT_RAW  = 'raw';
    const FORMAT_JSON = 'json';
    const FORMAT_HTML = 'html';

    public static $httpStatuses = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        118 => 'Connection timed out',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        210 => 'Content Different',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        310 => 'Too many Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested range unsatisfiable',
        417 => 'Expectation failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable entity',
        423 => 'Locked',
        424 => 'Method failure',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway or Proxy Error',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        507 => 'Insufficient storage',
        508 => 'Loop Detected',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    public function setData($data)
    {
        if (is_null($this->data)) {
            $this->data = $data;
        }
        return $this;
    }

    public function send()
    {
        if ($this->_hasSend) {
            return;
        }
        $this->sendHeader();
        if ($this->_statusCode != 200) {
            header("HTTP/{$this->version} {$this->_statusCode} {$this->_statusText}");
        }
        if ($this->data !== null) {
            echo $this->data;
        }
        $this->_hasSend = true;
        return;
    }

    public function sendHeader()
    {
        if ($this->format = self::FORMAT_JSON) {
            header("Content-type: application/json; charset=utf-8");
            if (is_array($this->data)) {
                $this->data = json_encode($this->data);
            }
        } elseif ($this->format = self::FORMAT_HTML) {
            header("Content-Type: text/html; charset=utf-8");
        }
        foreach ($this->_header as $name => $values) {
            $name = str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)));
            $replace = true;
            foreach ($values as $value) {
                header("$name: $value", $replace);
                $replace = false;
            }
        }
    }

    public function addHeader($name, $value)
    {
        $this->_header[$name] = $value;
        return $this;
    }

    public function setStatusCode($value, $text = null)
    {
        $this->_statusCode = (int)$value;
        if ($value < 100 || $value > 600) {
            throw new InvalidCallException('The HTTP status code is invalid' . $value);
        }
        if ($text === null) {
            $this->_statusText = isset(static::$httpStatuses[$this->_statusCode])
                ? static::$httpStatuses[$this->_statusCode] : '';
        } else {
            $this->_statusText = $text;
        }
        return $this;
    }
}