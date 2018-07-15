<?php namespace rde\core;

	class main {

		public function __construct() {

			$function = RDE_AM;
			$this->$function();

		}

		private function web() {

			$response = http\response::init();
			try {

			}
			catch(http\errorException $error) {}
			catch(http\missingException $missing) {}
			catch(http\redirectException $redirect) {}
			catch(http\authenticationExceotion $authentication) {}
			catch(http\authorizationException $authoorization) {}
			finally {
				$buffers = [];
				while(ob_get_level() > 1) $buffers[] = ob_get_clean();
				$buffers = array_reverse($buffers);
				foreach($buffers as $buffer) echo $buffer;
				$response->sendAll();
			}

		}

	}
