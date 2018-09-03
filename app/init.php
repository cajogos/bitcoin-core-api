<?php

// Enable dev mode (1) or disable (0)
define('DEV_MODE', 1);
if (DEV_MODE)
{
	ini_set('display_errors', DEV_MODE);
	ini_set('display_startup_errors', DEV_MODE);
	error_reporting(E_ALL);
}

session_start();

$root_path = $_SERVER['DOCUMENT_ROOT'] . '/../';

// Composer autoload
$vendor_autoload_location = $root_path . 'vendor/autoload.php';
if (file_exists($vendor_autoload_location))
{
	require $vendor_autoload_location;
}

// Load custom classes
spl_autoload_register(function ($class_name) {
	global $root_path;
	// Check if Class
	$location = $root_path . 'classes/' . $class_name . '.php';
	if (file_exists($location))
	{
		require_once $location;
	}
	else
	{
		// Check if Controller
		$location = $root_path . 'controllers/' . $class_name . '.php';
		if (file_exists($location))
		{
			require_once $location;
		}
		else
		{
			throw new Exception('Could not find class: ' . $class_name);
		}
	}
});

// Boot-up configurations
$file_name = $root_path . 'app/' . 'config.json';
$config_file = file_get_contents($file_name);
if ($config_file === false)
{
	throw new Exception('Could not load the configuration file!');
}
$config = json_decode($config_file);
if ($config === false)
{
	throw new Exception('Failed to parse the configuration file!');
}
Site::loadConfiguration($config);