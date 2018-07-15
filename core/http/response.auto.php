<?php namespace rde\core\http;

	class response {

		private static $singleton;
		private $code = 200;
		private $content = '';
		private $headers = [];
		private $codeSent = false;
		private $contentSent = false;
		private $headersSent = false;

		public static function init() { return self::$singleton ? self::$singleton : self::$singleton = new static; }

		public function setCode($code) { $this->code = (int)$code; return $this; }
		public function setContent($content = '', $append = false) { $this->content = $append ? $this->content . (string)$content : (string)$content; return $this; }
		public function setHeader($header, $value) { $this->headers[(string)$header] = $value; return $this; }
		public function setHeadersArray(array $headers) { foreach($headers as $header => $value) $this->setHeader($header, $value); return $this; }
		private function setCodeSent($bool = true) { $this->codeSent = (bool)$bool; return $this; }
		private function setContentSent($bool = true) { $this->contentSent = (bool)$bool; return $this; }
		private function setHeadersSent($bool = true) { $this->headersSent = (bool)$bool; return $this; }

		public function getCode() { return $this->code; }
		public function getContent() { return $this->content; }
		public function getHeader($header, $default = NULL) { return in_array((string)$header, array_keys($this->headers)) ? $this->headers[(string)$header] : $default; }
		public function getHeadersArray() { return $this->headers; }
		private function getCodeSent() { return $this->codeSent; }
		private function getContentSent() { return $this->contentSent; }
		private function getHeadersSent() { return $this->headersSent; }

		public function unsetHeader($header) { unset($this->headers[(string)$header]); return $this; }
		public function unsetHeadersArray() { $this->headers = []; return $this; }

		public function issetHeader($header) { return in_array((string)$header, array_keys($this->headers)); }

		public function getMessage() {

			switch($this->getCode()) {
				case 100: return 'Continue';
		    case 101: return 'Switching Protocols';
		    case 102: return 'Processing';
		    case 200: return 'OK';
		    case 201: return 'Created';
		    case 202: return 'Accepted';
		    case 203: return 'Non-Authoritative Information';
		    case 204: return 'No Content';
		    case 205: return 'Reset Content';
		    case 206: return 'Partial Content';
		    case 207: return 'Multi-Status';
		    case 208: return 'Already Reported';
		    case 226: return 'IM Used';
		    case 300: return 'Multiple Choices';
		    case 301: return 'Moved Permanently';
		    case 302: return 'Found';
		    case 303: return 'See Other';
		    case 304: return 'Not Modified';
		    case 305: return 'Use Proxy';
		    case 306: return 'Switch Proxy';
		    case 307: return 'Temporary Redirect';
		    case 308: return 'Permanent Redirect';
		    case 400: return 'Bad Request';
		    case 401: return 'Unauthorized';
		    case 402: return 'Payment Required';
		    case 403: return 'Forbidden';
		    case 404: return 'Not Found';
		    case 405: return 'Method Not Allowed';
		    case 406: return 'Not Acceptable';
		    case 407: return 'Proxy Authentication Required';
		    case 408: return 'Request Timeout';
		    case 409: return 'Conflict';
		    case 410: return 'Gone';
		    case 411: return 'Length Required';
		    case 412: return 'Precondition Failed';
		    case 413: return 'Request Entity Too Large';
		    case 414: return 'Request-URI Too Long';
		    case 415: return 'Unsupported Media Type';
		    case 416: return 'Requested Range Not Satisfiable';
		    case 417: return 'Expectation Failed';
		    case 418: return 'I\'m a teapot';
		    case 419: return 'Authentication Timeout';
		    case 420: return 'Enhance Your Calm';
		    case 420: return 'Method Failure';
		    case 422: return 'Unprocessable Entity';
		    case 423: return 'Locked';
		    case 424: return 'Failed Dependency';
		    case 424: return 'Method Failure';
		    case 425: return 'Unordered Collection';
		    case 426: return 'Upgrade Required';
		    case 428: return 'Precondition Required';
		    case 429: return 'Too Many Requests';
		    case 431: return 'Request Header Fields Too Large';
		    case 444: return 'No Response';
		    case 449: return 'Retry With';
		    case 450: return 'Blocked by Windows Parental Controls';
		    case 451: return 'Redirect';
		    case 451: return 'Unavailable For Legal Reasons';
		    case 494: return 'Request Header Too Large';
		    case 495: return 'Cert Error';
		    case 496: return 'No Cert';
		    case 497: return 'HTTP to HTTPS';
		    case 499: return 'Client Closed Request';
		    case 500: return 'Internal Server Error';
		    case 501: return 'Not Implemented';
		    case 502: return 'Bad Gateway';
		    case 503: return 'Service Unavailable';
		    case 504: return 'Gateway Timeout';
		    case 505: return 'HTTP Version Not Supported';
		    case 506: return 'Variant Also Negotiates';
		    case 507: return 'Insufficient Storage';
		    case 508: return 'Loop Detected';
		    case 509: return 'Bandwidth Limit Exceeded';
		    case 510: return 'Not Extended';
		    case 511: return 'Network Authentication Required';
		    case 598: return 'Network read timeout error';
		    case 599: return 'Network connect timeout error';
				default: return 'Unknown Response';
			}

		}

		public function sendCode() {

			if($this->getCodeSent()) trigger_error('http response code already sent', E_USER_WARNING);
			$protocol = request::init()->server->getValue('SERVER_PROTOCOL', 'HTTP/1.0');
			header($protocol . ' ' . $this->getCode() . ' ' . $this->getMessage());
			$this->setCodeSent();
			return $this;

		}

		public function sendContent() {

			if($this->getContentSent()) trigger_error('http response content already sent', E_USER_WARNING);
			echo $this->getContent();
			$this->setContentSent();
			return $this;

		}

		public function sendHeaders() {

			if($this->getheadersSent()) trigger_error('http response headers already sent', E_USER_WARNING);
			if($this->getContentSent()) trigger_error('http response headers cannot be sent after content', E_USER_WARNING);
			else {
				foreach($this->getHeadersArray() as $header => $value) header($header . ': ' . $value);
				$this->setHeadersSent();
			}
			return $this;

		}

		public function sendAll() {

			$this->sendCode()
				->sendHeaders()
				->sendContent();
			return $this;

		}

	}
