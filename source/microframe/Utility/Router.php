<?php
namespace Microframe\Utility;

class Router {

	private $route;
	private $isJson;

	public function __construct() {
		if (! isset($_GET['_route_'])) {
			$_GET['_route_'] = 'index';
		}
		$this->route = $_GET['_route_'];
		$this->isJson = false;
	}

	public function routeToController() {
		$parts = explode('/', $this->route);

		$controllerName = 'App\Controller\\' . ucfirst($parts[0]) . 'Controller';
		if (!isset($parts[1]) || $parts[1] == '' || $parts[1] == '/') {
			$method = 'index';
		} else {
			$method = $parts[1];
		}

// 		$this->authenticate($parts);

		try {
			$controller = new $controllerName;
		} catch (\Exception $e) {
			throw $e;
		}

		if (is_callable([$controller, $method])) {
			$result['methodResult'] = $controller->$method();
			$result['nav'] = $controller->getNav();
			$result['showLayout'] = $controller->getShowLayout();
			$this->isJson = $controller->getIsJson();
			return $result;
		} else {
			throw new \Exception('No such method ' . $parts[0] . '->' . $parts[1]);
		}
	}

	public function authenticate($parts) {
		$state = Session::getInstance();

		$userId = $state->get('userId', null);

		if (is_null($userId) && $parts[0] != 'authenticate') {
			$this->redirect('authenticate/login');
		}

		return true;
	}

	public function redirect($where = null, $params = []) {

		$get = '';
		if (! empty($params)) {
			$tmp = [];
			foreach ($params as $key => $value) {
				$tmp[] = $key . '=' . $value;
			}
			$get = '?' . implode('&', $tmp);
		}

		if (is_null($where)) {
			header("Location: http://" . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/' . APP_NAME . '/index');
			die();
		} else {
			header("Location: http://" . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] .  '/' . APP_NAME . '/' . $where . $get);
			die();
		}

	}

	public function getCallType() {
		if ($this->isJson === true) {
			return 'json';
		} else {
			return 'normal';
		}
	}
}