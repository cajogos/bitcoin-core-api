<?php

/**
 * Class APIResponse
 */
class APIResponse
{
	const STATUS_SUCCESS = 'success';
	const STATUS_FAIL = 'fail';
	/**
	 * @var string
	 */
	private $status = self::STATUS_SUCCESS;

	/**
	 * @param string $status
	 */
	public function setStatus($status)
	{
		$this->status = $status;
	}

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @var array
	 */
	private $result = array();

	/**
	 * @param array $result
	 */
	public function setResult(array $result)
	{
		$this->result = $result;
	}

	/**
	 * @return array
	 */
	public function getResult()
	{
		return $this->result;
	}

	public function displayResult()
	{
		header('Content-type: application/json');
		$output = array(
			'status' => $this->getStatus(),
			'result' => $this->getResult()
		);
		echo json_encode($output);
		exit;
	}

	const ERROR_NOT_FOUND = 404;
	const ERROR_INVALID_REQUEST_METHOD = 501;

	/**
	 * @param $error_code
	 * @param string|null $error_message
	 */
	public function displayFailure($error_code, $error_message = null)
	{
		$this->setStatus('fail');
		if (is_null($error_message))
		{
			$error_message = 'Unknown error code provided.';
			switch ($error_code)
			{
				case self::ERROR_NOT_FOUND:
					$error_message = 'Provided URL is not supported, please check documentation.';
					break;
				case self::ERROR_INVALID_REQUEST_METHOD:
					$error_message = 'Invalid request method provided, please check documentation.';
					break;
			}
		}
		$this->setResult(array(
			'error' => array(
				'code' => $error_code,
				'message' => $error_message
			)
		));
		$this->displayResult();
	}
}