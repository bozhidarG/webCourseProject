<?php
namespace App\Controller;

class BaseController {

	protected $nav;
	protected $isJson;
	protected $showLayout;

	public function __construct() {
		$this->isJson = false;
		$this->showLayout = true;
	}

	protected function setNav($id) {
		$this->nav = $id;
	}

	public function getNav() {
		return $this->nav;
	}

	public function getIsJson() {
		return $this->isJson;
	}

	public function getShowLayout() {
		return $this->showLayout;
	}
}