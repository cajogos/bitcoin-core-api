<?php

/**
 * Class Site
 */
class Site
{
	/**
	 * @var array
	 */
	private static $configuration = array();

	/**
	 * @param object $config
	 */
	public static function loadConfiguration($config)
	{
		foreach ($config as $key => $value)
		{
			self::$configuration[$key] = $value;
		}
	}

	/**
	 * @param string $key
	 * @return mixed|null
	 */
	public static function getConfiguration($key)
	{
		if (isset(self::$configuration[$key]))
		{
			return self::$configuration[$key];
		}
		return null;
	}
}