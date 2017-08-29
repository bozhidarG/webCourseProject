<?php
namespace Microframe\Utility;

class View {
	private $layout;

	private $rawParams;
	private $params;
	private $template;
	private $requestRoute;
	private $currentNav;
	private $showLayout;

	public function __construct(array $params, $template = '', $layout = '') {
		$this->requestRoute = $_GET['_route_'];
		$this->rawParams = $params['methodResult'];
		$this->currentNav = $params['nav'];
		$this->showLayout = $params['showLayout'];

		$this->setLayout($layout);
		$this->setTemplate($template);

		$this->decorate();
	}

	public function renderScreen() {

		ob_start();
		if ($this->showLayout) {
			$this->renderLayout();
		} else {
			$this->renderTemplate();
		}
		$result = ob_get_clean();
		return $result;
	}

	private function renderLayout() {

		require $this->layout;
	}

	public function renderTemplate() {

		require $this->template;
	}

	private function decorate() {

		foreach($this->rawParams as $key => $value)
		{
			if (is_string($value)) {
				$this->params[$key] = htmlentities($value);
			} else {
				$this->params[$key] = $value;
			}
		}
	}

	/**
	 * Magic getter for accessing the parameters in the template files
	 * @param string $paramName
	 * @return string
	 */
	public function __get($paramName) {
		$useRaw = false;
		if(strpos($paramName, '_raw')){
			$paramName = str_replace('_raw', '', $paramName);
			$useRaw = true;
		}

		if (isset($this->params[$paramName])) {
			if($useRaw){
				return $this->rawParams[$paramName];
			} else {
				return $this->params[$paramName];
			}
		} else {
			return '';
		}
	}

	private function setTemplate($template) {
		$parts = explode('/', $this->requestRoute);
		$folder = strtolower($parts[0]);

		if (!isset($parts[1]) || $parts[1] == '' || $parts[1] == '/') {
			$file = 'index';
		} else {
			$file = strtolower($parts[1]);
		}


		if ($template != '' && file_exists(BASE_VIEWS . $template . '.phtml')) {
			$this->template = BASE_VIEWS . $template . '.phtml';
		} elseif (file_exists(BASE_VIEWS . $folder . DIRECTORY_SEPARATOR . $file . '.phtml')) {
			$this->template = BASE_VIEWS . $folder . DIRECTORY_SEPARATOR . $file . '.phtml';
		} else {
			throw new \Exception('No such template '. BASE_VIEWS . $folder . DIRECTORY_SEPARATOR . $file . '.phtml');
		}
	}

	private function setLayout($layout) {
		if ($layout != '' && file_exists(BASE_VIEWS . $layout . '.phtml')) {
			$this->layout = $layout;
		} else {
			$this->layout = BASE_LAYOUT;
		}
	}

	public function renderTemplateOnDemand($template, $check = false) {

		if ($check == true) {
			$userId = Session::getInstance()->get('userId', false);
			if ($template != '' && file_exists(BASE_VIEWS . $template . '.phtml') && $userId !== false) {
				require BASE_VIEWS . $template . '.phtml';
			}
		} else {
			if ($template != '' && file_exists(BASE_VIEWS . $template . '.phtml')) {
				require BASE_VIEWS . $template . '.phtml';
			}
		}

	}

	public function getNav() {
		return $this->currentNav;
	}
}