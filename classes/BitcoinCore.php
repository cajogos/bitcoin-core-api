<?php

class BitcoinCore
{
	public static function getBlockChainInfo()
	{
		$api = BitcoinAPI::get();
		$api->setMethod('getblockchaininfo');
		return $api->getResult();
	}

	public static function getBalance($account = '')
	{
		$api = BitcoinAPI::get();
		$api->setMethod('getbalance');
		$api->addParam($account);
		return $api->getResult();
	}
}