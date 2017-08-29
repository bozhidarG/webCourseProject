<?php
use Microframe\Utility\Router;
use Microframe\Utility\View;
include_once 'Utility/config.php';
include_once 'Utility/autoloader.php';
include_once 'Utility/functions.php';

$router = new Router();
$params = $router->routeToController();

if ($router->getCallType() == 'normal') {
	$view = new View($params);
	$result = $view->renderScreen();
} else {
	$result = json_encode($params['methodResult']);
	header('Content-Type: application/json');
}

echo $result;
