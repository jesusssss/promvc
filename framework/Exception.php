<?php

namespace Framework {
    class Exception extends \Exception {

        public function _getExceptionForWriteonly() {
            echo "Exceptiopn for write only";
        }




    }
}