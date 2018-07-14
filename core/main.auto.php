<?php namespace rde\core;

        class main {

		public function __construct() {

			$function = RDE_AM;
			$this->$function();

		}

		private function web() { var_dump(single\http\request::i()); }

        }
