<?php

namespace Framework {
    class ArrayMethods {

        public function __construct() {
            //Do nothing
        }

        public function __clone() {
            //Do nothing
        }


        /**
         * clean() method removes all values considered empty() and return resultant array.
         * @param $array
         * @return array
         */
        public static function clean($array) {
            return array_filter($array, function($item) {
                return !empty($item);
            });
        }

        /**
         * trim() method returns an array, which contains all the items on the inital array,
         * -> after they have been trimmed of all whitespaces.
         * @param $array
         * @return array
         */

        public static function trim($array) {
            return array_map(function($item) {
                return trim($item);
            }, $array);
        }

    }
}