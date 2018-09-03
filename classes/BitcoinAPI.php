<?php

class BitcoinAPI extends APIResponse
{
	private static $instance = null;

	private $api_call = null;

	private $method = null;
	private $params = array();

	private function __construct()
	{

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


}