<?php namespace rde\core;

	class controller {

		private $am;
		private $controller;
		private $parameters = [];

		public function __construct($controller, $parameters, $am) {

			$this->setController($controller)
				->setParametersArray($parameters)
				->setAm($am);

		}

		public function setAm($am) { $this->am = (string)$am; return $this; }
		public function setController($controller) { $this->controller = (string)$controller; return $this; }
		public function setParameter($parameter) { $this->parameters[] = $parameter; return $this; }
		public function setParametersArray(array $parameters) { foreach($parameters as $parameter) $this->setParameter($parameter); return $this; }

		public function getAm() { return $this->am; }
		public function getController() { return $this->controller; }
		public function getParameter($index, $default = NULL) { return in_array((int)$index, array_keys($this->parameters)) ? $this->parameters[(int)$index] : $default; }
		public function getParametersArray() { return $this->parameters; }

		public function render() {

			$buffer = '';
			$controllerClass = '\\rde\\controllers\\' . $this->getController();
			$controller = new $controllerClass;
			if($controller) {
				$function = $this->getAm();
				if(!method_exists($controller, $function)) trigger_error($function . ' undefined in class ' . $controllerClass);
				else {
					ob_start();
					$this->$function($controller);
					$buffer = ob_get_clean();
				}
			}
			return $buffer;

		}

		private function web($controller) {

			$controller->web($this->getParametersArray());
			$viewFilepath = RDE_DR . 'views' . RDE_DS . str_replace('\\', RDE_DS, $this->getController()) . '.php';
			if(is_file($viewFilepath)) {
				$data = isset($controller->data) ? $controller->data : [];
				include($viewFilepath);
			}
			return $this;

		}

	}
