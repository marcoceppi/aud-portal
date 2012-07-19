<?php

define('APPLICATION_ROOT', dirname(__FILE__) . '/../');

set_include_path(get_include_path() . PATH_SEPARATOR . APPLICATION_ROOT . 'lib');

if( !is_file(APPLICATION_ROOT . 'inc/config.inc.php') )
{
	die('Configuration file not found, I am freaking out right now.');
}

function truncate($string, $limit, $pad = '&hellip;')
{
	return (strlen($string) <= $limit) ? $string : substr($string, 0, $limit) . $pad;
}

function is_assoc($array)
{
	return (bool)count(array_filter(array_keys($array), 'is_string'));
}

require_once(APPLICATION_ROOT . 'inc/config.inc.php');
require_once('helper/Loader.php');

session_start();

$http_dir_name = dirname($_SERVER['PHP_SELF']);

App::$View = new Template();
App::$View->compile_dir = APPLICATION_ROOT . 'views/_cache';
App::$View->template_dir = APPLICATION_ROOT . 'views';
App::$View->assign('BASE_URL', ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $http_dir_name . (($http_dir_name == '/') ? '' : '/'));
App::init();
