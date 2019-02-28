<?php
//Ko conf init
!defined('KO_DIR') && define('KO_DIR', VENDOR_DIR . '/mfw/ko/');
!defined('KO_PROXY') && define('KO_PROXY', getenv('KPROXY_IP'));
!defined("KINDTREE_DEBUG") && define("KINDTREE_DEBUG", intval(getenv('K8S_CLUSTER_TYPE') == 'dev'));
!defined("K_DEBUG") && define("K_DEBUG", intval(getenv('K_DEBUG') ?: 0));

!defined('KO_DB_ENGINE') && define('KO_DB_ENGINE', 'kproxy');
define('KO_MC_ENGINE', getenv('KO_MC_ENGINE') ?: 'kproxy');
define('KO_REDIS_ENGINE', getenv('KO_REDIS_ENGINE') ?: 'kproxy');

//Ko autoload
require(VENDOR_DIR . "/mfw/ko/ko.class.php");