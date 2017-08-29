<?php
namespace App\Model;

use Microframe\Utility\DbConnector;
class BaseModel {

	protected $dbPDO;

	public function __construct() {
		$this->dbPDO = DbConnector::getPdo();
	}

}