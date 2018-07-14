<?php namespace rde\core;

        class dict {

                private $values = [];

                public function __construct($values = []) { $this->setValuesArray($values); }

                public function setValue($key, $value) { $this->values[(string)$key] = $value; return $this; }
                public function setValuesArray(array $values) { foreach($values as $key => $value) $this->setValue($key, $value); return $this; }

                public function getValue($key, $default = NULL) { return in_array((string)$key, array_keys($this->values)) ? $this->values[(string)$key] : $default; }
                public function getValuesArray() { return $this->values; }

                public function unsetValue($key) { unset($this->values[(string)$key]); return $this; }
                public function unsetValuesArray() { $this->values = []; return $this; }

                public function issetValue($key) { return in_array((string)$key, array_keys($this->values)); }

        }
