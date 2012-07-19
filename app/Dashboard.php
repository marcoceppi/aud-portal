<?php

if( !defined('IN_APP') ) { die('DANGER WILL ROBINSON'); }

/**
 * Dashboard
 * 
 * This will manage and manipulate all of the dashboard functions
 * 
 * @author Marco Ceppi <marco@ceppi.net>
 * @package Portal
 * @subpackage Controller
 */
class Dashboard extends App
{
	/**
	 * Dashboard Init
	 * 
	 * @retun null
	 */
	public static function init()
	{
		static::view();
	}
	
	/**
	 * Dashboard View
	 * 
	 * @return null
	 */
	public static function view()
	{
		static::$View->display('view.tpl');
	}
}
