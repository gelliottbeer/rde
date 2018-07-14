<?php namespace rde\core;

        class single {

                private static $single;

                public static function i() { return self::$single ? self::$single : self::$single = new static; }

        }
