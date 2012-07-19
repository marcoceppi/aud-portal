<?php
/**
 * Main router
 *
 * So many people have frameworks out there, including one I built 
 * do all this jazz. But! WE'RE PROTOTYPING ON THE FLY GOGOGO. 
 * Proof of Concept <3. This should all be wrapped in a Router to handle
 * this kind of magic.
 * 
 * @author Marco Ceppi <marco@ceppi.net>
 * @package Amulet
 */

define('IN_APP', true);

require_once('lib/common.php');

$raw_route = (!empty($_GET['__r'])) ? rtrim($_GET['__r'], '/') : DEFAULT_CONTROLLER;

$route_segments = explode('/', $raw_route);
$controller = ucfirst(strtolower($route_segments[0]));

if( !file_exists('app/' . $controller . '.php') )
{
	$controller = DEFAULT_CONTROLLER;
	array_unshift($route_segments, $controller);
}
/*
 * Not sure if I should unshift and add the controller (could be helpful?)
 * or just drop the controller if it's present. Will think about this
 * @todo
 *
else
{
	array_shift($route_segments);
}
*/

//@todo Remove this line
User::$name = 'marco';
User::init();

// Double logic to make sure default route exists
if( file_exists('app/' . $controller . '.php') )
{
	require_once('app/' . $controller . '.php');

	// There might be a better way to do this, but load the View object in to
	// the controller. That way it has access? Might want to just have the App
	// extend the the View helper, but I wouldn't want things like assign 
	// and display to become reserved methods.
	App::$View->template_dir = array(APPLICATION_ROOT . 'views', APPLICATION_ROOT . 'views/' . strtolower($controller));
	App::$View->assign('TITLE', $controller);
	App::$View->assign('CONTROLLER', strtolower($controller));

	$method = (array_key_exists(1, $route_segments)) ? $route_segments[1] : DEFAULT_METHOD;
	$methods = get_class_methods($controller);
	
	if( is_null($methods) )
	{
		// Route not found, 404 page
		App::throw_error(404, 'Page not found');
	}

	if( !in_array($method, $methods) )
	{
		$method = DEFAULT_METHOD;
		$params = array_slice($route_segments, 1);
	}
	else
	{
		$params = array_slice($route_segments, 2);
	}

	call_user_func_array(array($controller, $method), $params);
}
else
{
	App::throw_error(404, 'Page not found');
}
