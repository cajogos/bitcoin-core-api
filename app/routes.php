<?php
/*
 * - Routing is done using AltoRouter (http://altorouter.com/usage/mapping-routes.html)
 */
$router = new AltoRouter();
$router->map('GET|POST', '/[a:api_method]', 'APIController::handleRequest');

/**
 * @param AltoRouter $router
 */
function handleRouting(AltoRouter $router)
{
	$match = $router->match();
	if ($match && is_callable($match['target']))
	{
		call_user_func_array($match['target'], $match['params']);
	}
	else
	{
		header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
		$api_response = new APIResponse();
		$api_response->displayFailure(APIResponse::ERROR_NOT_FOUND);
	}
}
handleRouting($router);