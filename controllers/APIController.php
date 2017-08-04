<?php

use Cajogos\Biscuit\Controller as Controller;

class APIController extends Controller
{
	public static function handleIndex()
	{
		echo 'no method';
		exit;
	}

	public static function handleMethod($api_method)
	{
		echo $api_method;
		exit;
	}
}