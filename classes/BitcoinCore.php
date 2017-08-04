<?php

class BitcoinCore
{
	public static function getBlockChainInfo()
	{
		$api = BitcoinAPI::get();
		$api->setMethod('getblockchaininfo');
		return $api->getResult();
	}
}