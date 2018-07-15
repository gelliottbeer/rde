<?php namespace rde\core;

	class config extends \rde\library\config {

		private static $singleton;

		public static function init() { return self::$singleton ? self::$singleton : self::$singleton = new static; }

		public function __construct() {

			parent::__construct(RDE_DR . 'config.json');
			if($this->fileExists()) $this->readFile();

		}

	}
