<?php

/**
 * Class CoreAPIRequest
 */
class CoreAPIRequest
{
	const ERROR_INVALID_METHOD = 601;
	const ERROR_INVALID_PARAM = 602;
	const ERROR_EXCEPTION_THROWN = 603;
	const ERROR_API_CALL = 604;

	/**
	 * @var APIResponse|null
	 */
	private $api_response = null;

	/**
	 * @var string|null
	 */
	private $api_call = null;

	/**
	 * @return string|null
	 */
	public function getAPICall()
	{
		return $this->api_call;
	}

	/**
	 * CoreAPIRequest constructor.
	 * @param APIResponse $api_response
	 */
	public function __construct(APIResponse $api_response)
	{
		$this->api_response = $api_response;

		$this->api_call = 'http://';
		$this->api_call .= Site::getConfiguration('rpc_username') . ':' . Site::getConfiguration('rpc_password') . '@';
		$this->api_call .= Site::getConfiguration('rpc_host') . ':' . Site::getConfiguration('rpc_port') . '/';
	}

	public function displayResponse()
	{
		$this->api_response->displayResult();
	}

	/**
	 * @var array Array of valid params - to be improved as needed
	 */
	private static $valid_params = array(
		'account', 'confirmations', 'watchOnly'
	);

	/**
	 * @var array
	 */
	private $params = array();

	/**
	 * @param array $params
	 */
	public function addParams(array $params)
	{
		foreach ($params as $key => $value)
		{
			if (!$this->addParam($key, $value))
			{
				$this->api_response->displayFailure(self::ERROR_INVALID_PARAM, "Invalid param provided $key, please check documentation.");
			}
		}
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @return bool
	 */
	public function addParam($key, $value)
	{
		if (in_array($key, self::$valid_params))
		{
			if ($value === 'false' || $value === 'true')
			{
				$value = (bool)$value;
			}
			$this->params[$key] = $value;
			return true;
		}
		return false;
	}

	const METHOD_GET_GETINFO = 'getinfo';
	const METHOD_GET_GETBALANCE = 'getbalance';

	/**
	 * GET: getinfo
	 */
	public function getInfo()
	{
		$response = $this->do_request(self::METHOD_GET_GETINFO);
		$output = $response['result'];
		$this->api_response->setResult($output);
	}

	/**
	 * GET: getBalance
	 * Params:
	 * - "account" [string] (Optional) An account name, use * to display ALL, empty string to display default account.
	 * --- "confirmations" [int] The minimum number of confirmations.
	 * --- "watchOnly" [bool] Whether to include watch-only addresses.
	 */
	public function getBalance()
	{
		$params = array();
		$account = '*';
		if (isset($this->params['account']))
		{
			$params[] = $this->params['account'];
			$account = $this->params['account'];
			if (isset($this->params['confirmations']))
			{
				$params[] = (int) $this->params['confirmations'];
				if (isset($this->params['watchOnly']))
				{
					$params[] = $this->params['watchOnly'];
				}
			}
		}
		$response = $this->do_request(self::METHOD_GET_GETBALANCE, $params);

		$output = array(
			'account' => $account,
			'balance' => $response['result']
		);

		$this->api_response->setResult($output);
	}

	private function do_request($method, $params = array())
	{
		$ch = curl_init();

		$http_header = array('Content-Type: text/plain');

		$post_fields = array();
		$post_fields['id'] = "core_api_request_$method";
		$post_fields['method'] = $method;
		$post_fields['params'] = $params;

		$json_post = json_encode($post_fields);

		curl_setopt($ch, CURLOPT_URL, $this->getAPICall());
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

		$result = json_decode($result, true);
		if (!is_null($result['error']))
		{
			// Error in the API request
			$error_message = 'Bitcoin Core Error! ';
			if (isset($result['error']['code']))
			{
				$error_message .= 'Code: ' . $result['error']['code'];
			}
			if (isset($result['error']['message']))
			{
				$error_message .= ' Message: ' . $result['error']['message'];
			}
			$this->api_response->displayFailure(self::ERROR_API_CALL, $error_message);
		}

		return array(
			'call_id' => $result['id'],
			'result' => $result['result']
		);
	}
}