<?php namespace rde\core\http;

	class routes extends \rde\library\config {

		private static $singleton;

		public static function init() { return self::$singleton ? self::$singleton : self::$singleton = new static; }

		public function __construct() {

			parent::__construct(RDE_DR . 'routes.json');
			if($this->fileExists()) $this->readFile();

		}

		public function getController() {

			$controller = NULL;
			$uri = request::init()->query->getValue('uri');
			foreach($this->getValuesArray() as $pattern => $candidate) {
				if(preg_match('/' . $pattern . '/', $uri)) {
					$controller = $candidate;
					break;
				}
			}
			return $controller;

		}

		public function getParameters() {

			return [];

		}

	}
