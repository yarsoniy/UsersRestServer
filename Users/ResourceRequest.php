<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 15.06.2015
 * Time: 19:03
 */

namespace Users;

abstract class ResourceRequest {

    protected $method;
    protected $resource;
    protected $operation;
    protected $resourceId;

    protected $availableOperations;

    abstract function createHandler();

    public static function parse() {
        $request = null;

        $uri = $_SERVER['REQUEST_URI'];
        $paramsBeginning = strpos($uri, '?');
        if ($paramsBeginning !== false) {
            $path = substr($uri, 0, $paramsBeginning);
        } else {
            $path = $uri;
        }

        $pathElements = explode('/', $path);
        if (!array_key_exists(1, $pathElements)) {
            return null;
        } elseif (!array_key_exists(2, $pathElements)) {
            return null;
        }

        $resource = $pathElements[1];
        $operation = $pathElements[2];
        $resourceId = null;
        if (array_key_exists(3, $pathElements)) {
            $resourceId = (int)$pathElements[3];
        }
        $method = self::parseMethod();

        $request = self::createRequest($method, $resource, $operation, $resourceId);
        return $request;
    }

    public static function hasParam($name) {
        return array_key_exists($name, $_REQUEST);
    }

    public static function getParam($name) {
        if (array_key_exists($name, $_REQUEST)) {
            return trim($_REQUEST[$name]);
        }
        return null;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getOperation() {
        return $this->operation;
    }

    public function getResourceId() {
        return $this->resourceId;
    }

    protected function setMethod($method) {
        if (in_array($method, array(GET, POST, PUT, DELETE))) {
            $this->method = $method;
        }
    }

    protected function setOperation($operation) {
        if (in_array($operation, $this->availableOperations)) {
            $this->operation = $operation;
        }
    }

    protected function setResourceId($id) {
        if (!$id) {
            $this->resourceId = null;
        } else {
            $this->resourceId = (int)$id;
        }
    }

    private static function createRequest($method, $resource, $operation, $id) {
        $result = null;
        switch ($resource) {
            case 'user':
                $result = new UserRequest($method, $operation, $id);
                break;
            default:
                break;
        }
        return $result;
    }

    private static function parseMethod() {
        $result = null;

        $method = null;
        if (self::hasParam('method')) {
            $method = self::getParam('method');
        }

        if (!$method) {
            $method = $_SERVER['REQUEST_METHOD'];
        }
        $result = $method;
        return $result;
    }
}