<?php namespace rde\library;

	class config {

		private $filepath;
		private $values = [];

		public function __construct($filepath) { $this->setFilepath($filepath); }

		public function setFilepath($filepath) { $this->filepath = (string)$filepath; return $this; }
		public function setValue($key, $value) { $this->values[(string)$key] = $value; return $this; }
		public function setValuesArray(array $values) { foreach($values as $key => $value) $this->setValue($key, $value); return $this; }

		public function getFilepath() { return $this->filepath; }
		public function getValue($key, $default = NULL) { return in_array((string)$key, array_keys($this->values)) ? $this->values[(string)$key] : $default; }
		public function getValuesArray() { return $this->values; }

		public function unsetValue($key) { unset($this->values[(string)$key]); return $this; }
		public function unsetValuesArray() { $this->values = []; return $this; }

		public function issetValue($key) { return in_array((string)$key, array_keys($this->values)); }

		public function readFile() {

			$this->unsetValuesArray();
			if(!$this->fileExists()) trigger_error('file \'' . $this->getFilepath() . '\'');
			elseif($values = json_decode(file_get_contents($this->getFilepath()), true)) $this->setValuesArray($values);
			return $this;

		}

		public function writeFile() {

			$handle = fopen($this->getFilepath(), 'w');
			if($handle) {
				fwrite($handle, json_encode($this->getValuesArray(), JSON_PRETTY_PRINT));
				fclose($handle);
			}
			return $this;

		}

		public function fileExists() { return file_exists($this->getFilepath()); }

	}
