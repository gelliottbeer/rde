<?php namespace rde\core;

	class main {

		public function __construct() {

			$function = RDE_AM;
			$this->$function();

		}

		private function web() {

			$response = http\response::init();
			try {
				$routes = http\routes::init();
				$controller = $routes->getController();
				$parameters = $routes->getParameters();
				if(!$controller) throw new http\missingException();
				else {
					$controller = new controller($controller, $parameters, RDE_AM);
					$response->setContent($controller->render());
				}
			}
			catch(http\errorException $error) {
				$response->unsetHeadersArray()
					->setCode(500)
					->setContent(NULL);
			}
			catch(http\missingException $missing) {
				$response->unsetHeadersArray()
					->setCode(404)
					->setContent(NULL);
			}
			catch(http\redirectException $redirect) {
				$location = $redirect->getLocation();
				$response->unsetHeadersArray()
					->setHeader('Location', $location)
					->setCode(303)
					->setContent(NULL);
			}
			catch(http\authenticationExceotion $authentication) {
				$location = $authentication->getLocation();
				$response->unsetHeadersArray()
					->setCode(403)
					->setContent(NULL);
				if($location) $response->setHeader('Location', $location);
			}
			catch(http\authorizationException $authorization) {
				$response->unsetHeadersArray()
					->setCode(403)
					->setContent(NULL);
			}
			finally {
				$buffers = [];
				while(ob_get_level() > 1) $buffers[] = ob_get_clean();
				$buffers = array_reverse($buffers);
				if(config::init()->getValue('debug')) foreach($buffers as $buffer) echo $buffer;
				$response->sendAll();
			}

		}

	}
