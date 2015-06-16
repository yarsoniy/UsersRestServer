<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 16.06.2015
 * Time: 14:28
 */

namespace Users;

/* Response codes
200: OK
201: Created
400: Bad request
404: Not found
*/

class Response {
    private $code;
    private $data;

    public function __construct($code, $data = null) {
        $this->code = (int)$code;
        $this->error = false;
        $this->errorMsg = "";
        $this->data = $data;
    }

    public function setError($isError, $msg) {
        $this->error = (bool)$isError;
        $this->errorMsg = (string)$msg;
    }

    public function respond() {
        header('Content-Type: text/json');
        http_response_code($this->code);

        $object = new \stdClass();
        if ($this->error) {
            $object->errorMsg = $this->errorMsg;
        } elseif ($this->data) {
            $object->data = $this->data;
        }

        $result = json_encode($object);
        echo $result;
    }
}