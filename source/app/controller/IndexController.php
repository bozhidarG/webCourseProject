<?php
namespace App\Controller;

use App\Model\IndexModel;

class IndexController extends BaseController{

	public function index() {

		$model = new IndexModel();

		$helloWorld = $model->index();

		return [
			'hello' => $helloWorld,
		];
	}
}