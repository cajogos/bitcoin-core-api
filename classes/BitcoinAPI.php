<?php

/* Class used to query the Bitcoin Core JSON RPC. */

class BitcoinAPI extends APIResponse
{
	private static $instance = null;

	private $api_call = null;

	private $method = null;
	private $params = array();

	private function __construct()
	{
		$this->api_call = 'http://';
		$this->api_call .= Site::getConfiguration('rpc_username') . ':' . Site::getConfiguration('rpc_password') . '@';
		$this->api_call .= Site::getConfiguration('rpc_host') . ':' . Site::getConfiguration('rpc_port') . '/';
	}

	public static function get()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function setMethod($method)
	{
		$this->method = $method;
	}

	public function addParam($param)
	{
		// Boolean params
		if ($param === 'false' || $param === 'true')
		{
			$param = (bool)$param;
		}
		$this->params[] = $param;
	}

	public function getResult()
	{
		if (!is_null($this->method))
		{
			$result = $this->curl();
			$this->setResult($result);
		}
		parent::displayResult();
	}

	private function curl()
	{
		$ch = curl_init();

		$http_header = array('Content-Type: text/plain');

		$post_fields = array();
		$post_fields['jsonrpc'] = '1.0';
		$post_fields['id'] = 'curltext';
		$post_fields['method'] = $this->method;
		$post_fields['params'] = $this->params;

		$json_post = json_encode($post_fields);

		curl_setopt($ch, CURLOPT_URL, $this->api_call);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);

		$result = curl_exec($ch);

		if ($result === false)
		{
			$curl_error = curl_error($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			if ($http_code !== 200)
			{
				$result = array(
					'message' => 'Curl error',
					'details' => $curl_error
				);
				return $result;
			}
		}

		$result_object = json_decode($result);
		return (array)$result_object;
	}
}