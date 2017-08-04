<?php

use Cajogos\Biscuit\Controller as Controller;

class APIController extends Controller
{
	public static function handleIndex()
	{
		echo 'no method';
		exit;
	}

	public static function handleMethod($api_method)
	{
		$api_method = self::cleanup_method($api_method);

		switch ($api_method)
		{
			case 'getinfo':
			case 'getblockchaininfo':
				BitcoinCore::getBlockChainInfo();
				break;
			case 'getbalance';
				BitcoinCore::getBalance();
				break;
			default:
				break;
		}
	}

	private static function cleanup_method($method)
	{
		$method = trim($method);
		$method = strip_tags($method);
		$method = strtolower($method);
		return $method;
	}
}