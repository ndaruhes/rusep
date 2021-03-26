<?php
    class Session{
        public static function set($name, $value){
            return $_SESSION[$name] = $value;
        }

        public static function exists($name){
            return isset($_SESSION[$name]);
        }

        public static function name($name){
            return $_SESSION[$name];
        }

    }
?>