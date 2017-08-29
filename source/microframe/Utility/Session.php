<?php
namespace Microframe\Utility;

class Session {

	static private $sessionInstance;

	static public function getInstance() {
		if (!isset(self::$sessionInstance)) {
			self::$sessionInstance = new self();
		}

		return self::$sessionInstance;
	}

	private function __construct() {
		session_start();
	}

	public function get($key, $default = '') {
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		} else {
			return $default;
		}
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function clear($key = '')
	{
		if ($key != '') {
			unset($_SESSION[$key]);
		} else {
			session_unset();
		}
	}

}