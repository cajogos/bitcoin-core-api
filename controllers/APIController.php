<?php

use Cajogos\Biscuit\Controller as Controller;

/**
 * Class APIController
 */
class APIController extends Controller
{
	/**
	 * @var APIResponse|null
	 */
	private static $api_response = null;

	/**
	 * @param string $method
	 */
	public static function handleRequest($method)
	{
		self::$api_response = new APIResponse();
		$method = self::cleanup_method($method);
		if (!empty($method))
		{
			switch (Request::getMethod())
			{
				case Request::METHOD_GET:
					self::handle_get($method);
					break;
				case Request::METHOD_POST:
					self::handle_post($method);
					break;
			}
		}
		self::$api_response->displayFailure(APIResponse::ERROR_INVALID_REQUEST_METHOD);
	}

	/**
	 * @param string $method
	 * @return string
	 */
	private static function cleanup_method($method)
	{
		$method = trim($method);
		$method = strip_tags($method);
		return $method;
	}

	/**
	 * @param string $method
	 */
	private static function handle_get($method)
	{
		$params = $_GET;
		try
		{
			$core_api = new CoreAPIRequest(self::$api_response);
			$core_api->addParams($params);
			switch ($method)
			{
				case CoreAPIRequest::METHOD_GET_GETINFO:
					$core_api->getInfo();
					break;
				case CoreAPIRequest::METHOD_GET_GETBALANCE:
					$core_api->getBalance();
					break;
				case CoreAPIRequest::METHOD_GET_GETWALLETINFO:
					$core_api->getWalletInfo();
					break;
				default:
					self::$api_response->displayFailure(CoreAPIRequest::ERROR_INVALID_METHOD, "Invalid method GET $method provided, please check documentation.");
					break;
			}
			$core_api->displayResponse();
		}
		catch (CoreAPIRequestException $e)
		{
			self::$api_response->displayFailure(CoreAPIRequest::ERROR_EXCEPTION_THROWN, $e->getMessage());
		}
	}

	/**
	 * @param string $method
	 */
	private static function handle_post($method)
	{
		$params = $_POST;
		try
		{
			$core_api = new CoreAPIRequest(self::$api_response);
			$core_api->addParams($params);
			switch ($method)
			{
				default:
					self::$api_response->displayFailure(CoreAPIRequest::ERROR_INVALID_METHOD, "Invalid method POST $method provided, please check documentation.");
					break;
			}
			$core_api->displayResponse();
		}
		catch (CoreAPIRequestException $e)
		{
			self::$api_response->displayFailure(CoreAPIRequest::ERROR_EXCEPTION_THROWN, $e->getMessage());
		}
	}
}