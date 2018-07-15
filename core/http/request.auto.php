<?php namespace rde\core\http;

	class request {

		private static $singleton;
		private $query;
		private $post;
		private $server;
		private $headers;
		private $files;

		public static function init() { return self::$singleton ? self::$singleton : self::$singleton = new static; }

		private function __construct() {

			$this->initQuery()
				->initPost()
				->initServer()
				->initHeaders()
				->initFiles();

		}

		private function initQuery() { $this->query = new \rde\library\dictionary($_GET); return $this; }
		private function initPost() { $this->post = new \rde\library\dictionary($_POST); return $this; }
		private function initServer() { $this->server = new \rde\library\dictionary($_SERVER); return $this; }

		private function initHeaders() {

			$prefix = 'HTTP_';
			$headers = [];
			foreach($_SERVER as $key => $value) {
				if(strpos($key, $prefix) === 0) {
					$key = strtolower(substr_replace($key, '', 0, strlen($prefix)));
					$key = str_replace(' ', '-', ucwords(str_replace('_', ' ', $key)));
					$headers[$key] = $value;
				}
			}
			$this->headers = new \rde\library\dictionary($headers);
			return $this;

		}

		private function initFiles() { $this->files = new \rde\library\dictionary($_FILES); return $this; }

		public function __get($name) { return $this->$name; }

	}
