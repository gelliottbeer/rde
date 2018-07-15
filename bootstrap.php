<?php namespace rde;

	// Define filesystem constants
	if(!defined('RDE_DS')) define('RDE_DS', DIRECTORY_SEPARATOR);
	if(!defined('RDE_DR')) define('RDE_DR', dirname(__FILE__) . RDE_DS);

	// Die if RDE_AM undefined
	if(!defined('RDE_AM')) die('RDE_AM undefined');

	// Setup lazy-loading
	spl_autoload_register(function($class) {

		$prefix = 'rde\\';
		if(strpos($class, $prefix) === 0) {
			$filepath = RDE_DR . str_replace('\\', RDE_DS, substr_replace($class, '', 0, strlen($prefix))) . '.auto.php';
			if(is_file($filepath)) include($filepath);
		}

	});

	// Start the application
	new core\main;
