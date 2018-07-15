<?php namespace rde\core;

	class mysql {

		private static $singleton;
		private $host;
		private $user;
		private $pass;
		private $name;
		private $link;

		public static function init() { return self::$singleton ? self::$singleton : self::$singleton = new static; }

		public function __construct($host, $user, $pass, $name) {

			$this->setHost($host)
				->setUser($user)
				->setPass()
				->setName();

		}

		public function setHost($host) { $this->host = (string)$host; return $this; }
		public function setUser($user) { $this->user = (string)$user; return $this; }
		public function setPass($pass) { $this->pass = (string)$pass; return $this; }
		public function setName($name) { $this->name = (string)$name; return $this; }

		public function getHost() { return $this->host; }
		public function getUser() { return $this->user; }
		public function getPass() { return $this->pass; }
		public function getname() { return $this->name; }

		public function connect() {

			$this->link = new mysqli(
				$this->getHost(),
				$this->getUser(),
				$this->getPass(),
				$this->getName()
			);

		}

		public function disconnect() {

			if($this->link) $this->link->close();
			$this->link = NULL;

		}

		public function query($sql) {

			return $this->link->query($sql);

		}

		public function escape($string) {

			return $this->link->real_escape_string($string);

		}

	}
