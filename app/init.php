<?php

session_start();

// Add the configuration file
$config_location = $_SERVER['DOCUMENT_ROOT'] . '/../app/config.php';
if (file_exists($config_location))
{
	require $config_location;
}

if (DEV_MODE)
{
	ini_set('display_errors', DEV_MODE);
	ini_set('display_startup_errors', DEV_MODE);
	error_reporting(E_ALL);
}

// Composer autoload
$vendor_autoload_location = $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';
if (file_exists($vendor_autoload_location))
{
	require $vendor_autoload_location;
}

// Load custom classes
spl_autoload_register(function ($class_name)
{
	// Check if Class
	$location = $_SERVER['DOCUMENT_ROOT'] . '/../classes/' . $class_name . '.php';
	if (file_exists($location))
	{
		require_once $location;
	}
	else
	{
		// Check if Controller
		$location = $_SERVER['DOCUMENT_ROOT'] . '/../controllers/' . $class_name . '.php';
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