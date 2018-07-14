<?php namespace rde;

	// Define filesystem constants
	if(!defined('RDE_DS')) define('RDE_DS', DIRECTORY_SEPARATOR);
	if(!defined('RDE_DR')) define('RDE_DR', dirname(__FILE__) . RDE_DS);
	// Die if AM undefined
	if(!defined('RDE_AM')) die('RDE_AM undefined');

	// Autoload classes in the rde root namespace
	spl_autoload_register(function($class) {

		$prefix = 'rde\\';
		if(strpos($class, 'rde\\') === 0) {
			$filepath = RDE_DR . str_replace(
					'\\',
					RDE_DS,
					substr_replace(
						$class,
						'',
						0,
						strlen($prefix)
					)




                                ) . '.auto.php';
			if(is_file($filepath)) include($filepath);
			
		}

	});
        
	// Initialise the application
        new core\main;
