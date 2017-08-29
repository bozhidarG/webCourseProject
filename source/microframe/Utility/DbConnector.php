<?php
namespace Microframe\Utility;

use \PDO;
class DbConnector
{
	private static $instance;

	private $pdo;

	public static function getPdo($dbHost = DB_HOST, $dbName = DB_NAME)
	{
		if (!isset(self::$instance[$dbName . $dbHost])) {
			self::$instance[$dbName . $dbHost] = new self($dbHost, $dbName);
		}

		return self::$instance[$dbName . $dbHost]->pdo;
	}

	static public function execute($query, $data = array(), $conn = array())
	{
		$dbHost = (isset($conn['host']) ? $conn['host'] : DB_HOST);
		$dbName = (isset($conn['db']) ? $conn['db'] : DB_NAME);

		$pdo = self::getPdo($dbHost, $dbName);

		$stm = $pdo->prepare($query);
		$stm->execute($data);
		return $stm;
	}

	private function __construct($dbHost = DB_HOST, $dbName = DB_NAME)
	{
		$dsn = "mysql:dbname={$dbName};host=". $dbHost .";charset=utf8";
		$this->pdo = self::createPDO($dsn);
	}

	private static function createPDO($dsn)
	{
		$pdo = new PDO($dsn, DB_USER, DB_PASS);

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	}
}