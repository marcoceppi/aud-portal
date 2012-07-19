<?php

class Loader
{
	public static $library_paths = array();

	public static function loadClass($className)
	{
		// we assume the class AAA\BBB\CCC is placed in /AAA/BBB/CCC.php
		$className = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $className);
		// we build the filename to require
		$load = $className . '.php';
		// check for file existence
		foreach( static::$library_paths as $path )
		{
			if( file_exists(APPLICATION_ROOT . 'lib' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $load) )
			{
				require_once($path . DIRECTORY_SEPARATOR . $load);
				break;
			}
		}
		
		return class_exists($className, false);
	}

	public static function find_lib()
	{
		if( $handle = opendir(APPLICATION_ROOT . 'lib') )
		{
			while( ($entry = readdir($handle)) !== FALSE)
			{
				if( !in_array($entry, array('.', '..')) && is_dir(APPLICATION_ROOT . 'lib' . DIRECTORY_SEPARATOR . $entry) )
				{
					static::$library_paths[] = $entry;
				}
			}

			closedir($handle);
		}
	}

	public static function register()
	{
		static::find_lib();
		spl_autoload_register("Loader::loadClass");
	}

	public static function unregister()
	{
		spl_autoload_unregister("Loader::loadClass");
	}
}

Loader::register();
