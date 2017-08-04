<?php

abstract class APIResponse
{
	private $result = array();

	protected function setResult($result)
	{
		$this->result = $result;
	}

	public function displayResult()
	{
		header('Content-type: application/json');
		echo json_encode($this->result);
		exit;
	}

	protected function getResult()
	{
		return $this->result;
	}
}