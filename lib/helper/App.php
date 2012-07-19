<?php
/**
 * Application Controller
 * 
 * @author Marco Ceppi <marco@ceppi.net>
 * @package Amulet
 * @subpackge Helper
 */

/**
 * Application Controller
 * 
 * @author Marco Ceppi <marco@ceppi.net>
 * @package Amulet
 * @subpackge Helper
 */
class App
{
	/** @type Smarty Template view for framework **/
	public static $View;
	/** @type array Alerts to be displayed on page load **/
	private static $alerts = array();

	/**
	 * Init
	 * 
	 * This method is designed to maintain magic between sessions and set up
	 * defaults.
	 * 
	 * @return null
	 */
	public static function init()
	{
		// Go through all the sessions and exec appropriate routes
		if( !array_key_exists(__CLASS__, $_SESSION) )
		{
			$_SESSION[__CLASS__] = array();
		}

		foreach($_SESSION[__CLASS__] as $method => $values)
		{
			$invoke = array();
			$func = new ReflectionMethod(__CLASS__, $method);
			$parameters = $func->getParameters();

			if( is_assoc($values) )
			{
				foreach($parameters as $parameter)
				{
					$invoke[$parameter->getPosition()] = $values[$parameter->getName()];
				}

				call_user_func_array(array(__CLASS__, $method), $invoke);
			}
			else
			{
				foreach($values as $param)
				{
					foreach($parameters as $parameter)
					{
						$invoke[$parameter->getPosition()] = $param[$parameter->getName()];
					}

					call_user_func_array(array(__CLASS__, $method), $invoke);
				}
			}

			unset($_SESSION[__CLASS__][$method]);
		}
	}

	/**
	 * Throw Error
	 * 
	 * Used when you need to envoke an error page.
	 * 
	 * @param int $code Typically 404,500,etc
	 * @param string $message optional
	 * 
	 * @reutrn VOID
	 */
	public static function throw_error($code, $message = '')
	{
		if( !empty($message) )
		{
			static::$View->assign('MESSAGE', $message);
		}
		
		header("HTTP/1.0 $code");
		
		if( is_file(static::$View->template_dir[0] . 'errors/' . $code . '.tpl') )
		{
			static::$View->display('errors/' . $code . '.tpl');
		}
		else
		{
			static::$View->display('_error.tpl');
		}
	}

	/**
	 * Alert
	 * 
	 * Display a gloal alert in the header
	 * 
	 * @param string $message
	 * @param string $type optional
	 * @param string $heading optional
	 * 
	 * @return VOID
	 */
	public static function alert($message, $type = 'info', $heading = '')
	{
		static::$alerts[] = array('type' => $type, 'message' => $message, 'heading' => $heading);
		static::$View->assign('ALERTS', static::$alerts);
	}

	/**
	 * Flash
	 * 
	 * Store an alert to be shown on the next session load
	 * 
	 * @param string $message
	 * @param string $type optional
	 * @param string $heading optional
	 * 
	 * @return VOID
	 */
	public static function flash($message, $type = 'info', $heading = '')
	{
		if( !array_key_exists('alert', $_SESSION['App']) )
		{
			$_SESSION['App']['alert'] = array();
		}
		
		$_SESSION['App']['alert'][] = array('message' => $message, 'type' => $type, 'heading' => $heading);
	}

	/**
	 * Redirect
	 * 
	 * Redirect the user to a relative path
	 * 
	 * @param string $path
	 * 
	 * @return VOID
	 */
	public static function redirect($path)
	{
		header('Location: ' . $path);
	}
}
