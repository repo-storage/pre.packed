<?php
date_default_timezone_set('US/Eastern');
define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
define('CONTENT_DIR', ROOT_DIR .'content/');
define('CONTENT_EXT', '.md');
define('LIB_DIR', ROOT_DIR .'lib/');
define('PLUGINS_DIR', ROOT_DIR .'plugins/');
define('THEMES_DIR', ROOT_DIR .'themes/');
define('CACHE_DIR', LIB_DIR .'cache/');

require(ROOT_DIR .'vendor/autoload.php');
require(LIB_DIR .'pico.php');
$pico = new Pico();
require(LIB_DIR .'Pico_Extended.php');
//$pico = new Pico_Extended();
