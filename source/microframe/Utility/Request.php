<?php
namespace Microframe\Utility;

class Request {

	private $post = [];
	private $get = [];
	static private $requestInstance;

	static public function getInstance() {
		if (!isset(self::$requestInstance)) {
			self::$requestInstance = new self();
		}

		return self::$requestInstance;
	}

	private function __construct() {
		$this->get = $_GET;
		unset($this->get['_route_']);
		$this->post = $_POST;
	}

	public function post($exact = '', $default = '') {
		if ($exact == '') {
			return $this->post;
		}

		if (isset($this->post[$exact])) {
			return $this->post[$exact];
		} else {
			return $default;
		}
	}

	public function get($exact = '', $default = '') {
		if ($exact == '') {
			return $this->get;
		}

		if (isset($this->get[$exact])) {
			return $this->get[$exact];
		} else {
			return $default;
		}
	}
}