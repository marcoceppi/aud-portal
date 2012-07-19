<?php
/**
 * HTTP
 * 
 * @author Marco Ceppi <marco@ceppi.net>
 * @package Amulet
 * @subpackage Helper
 */

/**
 * HTTP Methods
 */
define('HTTP_POST', 'POST');
define('HTTP_GET', 'GET');
define('HTTP_DELETE', 'DELETE');
define('HTTP_PUT', 'PUT');

/**
 * HTTP Exception
 * @author Marco Ceppi <marco@ceppi.net>
 * @package Amulet
 * @subpackage Helper
 */
class HTTPException extends Exception {}

/**
 * HTTP Helper
 * 
 * @author Marco Ceppi <marco@ceppi.net>
 * @package Amulet
 * @subpackage Helper
 */
class HTTP
{
	/**
	 * Method
	 * 
	 * Get the HTTP Method
	 * 
	 * @return string
	 */
	public static function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Data
	 * 
	 * Get HTTP Data depending on the method
	 * 
	 * @param string $param
	 * @param string $method optional
	 * 
	 * @return mixed
	 */
	public static function data($param, $method = NULL)
	{
		switch(static::method())
		{
			case HTTP_POST:
				return (array_key_exists($param, $_POST)) ? $_POST[$param] : FALSE;
			break;
			case HTTP_GET:
				return (array_key_exists($param, $_GET)) ? $_GET[$param] : FALSE;
			break;
			default:
				return (array_key_exists($param, $_REQUEST)) ? $_REQUEST[$param] : FALSE;
			break;
		}
	}
}
