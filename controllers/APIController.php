<?php

use Cajogos\Biscuit\Controller as Controller;

class APIController extends Controller
{
	public static function handleIndex()
	{
		$methods = array(
			'getinfo',
			'getblockchaininfo',
			'getbalance'
		);

		print '<h1>Available Methods:</h1>';
		foreach ($methods as $method)
		{
			print '<a href="/' . $method . '" target="blank">' . $method . '</a><hr />';
		}
	}

	public static function handleMethod($api_method)
	{
		$api_method = self::cleanup_method($api_method);

		switch ($api_method)
		{
			case 'getinfo':
			case 'getblockchaininfo':
				$api = BitcoinAPI::get();
				$api->setMethod('getblockchaininfo');
				return $api->getResult();
			case 'getbalance';
				$api = BitcoinAPI::get();
				$api->setMethod('getbalance');
//				$api->addParam($account);
				return $api->getResult();
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