<?php
namespace Framework {

    use Framework\Inspector as Inspector;
    use Framework\ArrayMethods as ArrayMethods;
    use Framework\StringMethods as StringMethods;

    class Base {
        private $_insepctor;

        public function __construct($options = array()) {
            $this->_insepctor = new Inspector($this);

            if(is_array($options) || is_object($options)) {
                foreach ($options as $key => $value) {
                    $key = ucfirst($key);
                    $method = "set{$key}";
                    $this->$method($value);
                }
            }
        }

        public function __call($name, $arguments) {
            if(empty($this->_insepctor)) {
                throw new Exception("Call parent::__construct!");
            }
            $getMatches = StringMethods::match($name, "^get([a-zA-Z0-9]+)$");
            if(sizeof($getMatches) > 0) {
                $normalized = lcfirst($getMatches[0]);
                $property = "_{$normalized}";

                if(property_exists($this, $property)) {
                    $meta = $this->_insepctor->getPropertyMeta($property);
                    if(empty($meta["@readwrite"]) && empty($meta["@read"])) {
                        throw $this->_getExceptionForWriteonly($normalized);
                    }
                    if(isset($this->$property)) {
                        return $this->$property;
                    }
                    return null;
                }
            }

            $setMatches = StringMethods::match($name, "^set([a-zA-Z0-9]+)$");
            if(sizeof($setMatches) > 0) {
                $normalized = lcfirst($setMatches[0]);
                $propertu = "_{$normalized}";

                if(property_exists($this, $property)) {
                    $meta = $this->_insepctor->getPropertyMeta($property);

                    if(empty($meta["@readwrite"]) && empty($meta["@write"])) {
                        throw $this->_getExceptionForReadonly($normalized);
                    }

                    $this->$property = $arguments[0];
                    return $this;
                }
            }
            throw $this->_getExceptionForImplementation($name);
        }


    }
}