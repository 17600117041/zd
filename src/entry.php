<?php
ini_set('display_errors', 'on');
//error_reporting(E_ALL || E_STRICT);
//date_default_timezone_set('Asia/Shanghai');
//ini_set('memory_limit', '1024M');


//int
define('ROOT_DIR', __DIR__);
define('VENDOR_DIR', ROOT_DIR . '/vendor');

//
require_once(VENDOR_DIR . '/autoload.php');
require_once(ROOT_DIR . '/bootstrap.php');
require ROOT_DIR . '/Z.php';

spl_autoload_register(['Z', 'autoload'], true, true);
Z::$app = new \base\web\Application([
    'container' => new base\Container()
]);
Z::$app->run();