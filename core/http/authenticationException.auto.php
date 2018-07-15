<?php namespace rde\core\http;

	class authenticationException extends \Exception {

		public function __construct($location = '') { parent::__construct($location, 0, NULL); }

		public function getLocation() { return parent::getMessage(); }

	}
