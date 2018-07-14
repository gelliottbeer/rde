<?php namespace rde\core\single\http;

        class request extends \rde\core\single\http {

                private $query;
                private $post;
                private $server;
                private $headers;
                private $files;

                protected function __construct() {

                        $this->initQuery()
                                ->initPost()
                                ->initServer()
                                ->initHeaders()
                                ->initFiles();

                }

                private function initQuery() { $this->query = new \rde\core\dict($_GET); return $this; }
                private function initPost() { $this->post = new \rde\core\dict($_POST); return $this; }
                private function initServer() { $this->server = new \rde\core\dict($_SERVER); return $this; }

                private function initHeaders() {

                        $prefix = 'HTTP_';
                        $headers = [];
                        foreach($_SERVER as $key => $value) {
                                if(strpos($key, $prefix) === 0) {
                                        $key = strtolower(substr_replace($key, '', 0, strlen($prefix)));
                                        $key = ucwords(str_replace('_', ' ', $key));
                                        $key = str_replace(' ', '-', $key);
                                        $headers[$key] = $value;
                                }
                        }
                        $this->headers = new \rde\core\dict($headers);
                        return $this;

                }

                private function initFiles() { $this->files = new \rde\core\dict($_FILES); return $this; }

        }
