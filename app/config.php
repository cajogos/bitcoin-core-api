<?php

// Enable dev mode (1) or disable (0)
define('DEV_MODE', 1);

// Global definitions - Change these to match your own Bitcoin Core information
$bitcoin_config = file_get_contents('/home/bitcoiner/.bitcoin/bitcoin.conf');
$bitcoin_config = explode("\n", $bitcoin_config);

$temp_array = array();
foreach ($bitcoin_config as $config)
{
	if (strpos($config, '=') === false)
	{
		continue;
	}
	$bits = explode('=', $config);
	$temp_array[$bits[0]] = $bits[1];
}
$bitcoin_config = $temp_array;

define('RPC_USER', $bitcoin_config['rpcuser']);
define('RPC_PASSWORD', $bitcoin_config['rpcpassword']);
define('RPC_HOST', '127.0.0.1');
define('RPC_PORT', '8332');
