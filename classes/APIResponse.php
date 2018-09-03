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

	/**
	 * @param int $error_code
	 */
	public function displayFailure($error_code)
	{
		$this->setStatus('fail');
		$error_message = 'Unknown error code provided.';
		switch ($error_code)
		{
			case self::ERROR_NOT_FOUND:
				$error_message = 'Provided URL is not supported, please check documentation.';
				break;
		}
		$this->setResult(array(
			'errorCode' => $error_code,
			'errorMessage' => $error_message
		));
		$this->displayResult();
	}
}