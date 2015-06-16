<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 16.06.2015
 * Time: 12:30
 */

namespace Users;


class UserRequest extends ResourceRequest {

    protected $resource = 'user';
    protected $availableOperations = array(
        'get',
        'list',
        'add',
        'edit',
        'delete'
    );

    function __construct($method, $operation, $id) {
        $this->setMethod($method);
        $this->setOperation($operation);
        $this->setResourceId($id);
    }

    function createHandler() {
        $handler = null;

        switch ($this->operation) {
            case 'get':
                $handler = new UserGetHandler($this);
                break;
            case 'list':
                $handler = new UserListHandler($this);
                break;
            case 'add':
                $handler = new UserAddHandler($this);
                break;
            case 'edit':
                $handler = new UserEditHandler($this);
                break;
            case 'delete':
                $handler = new UserRemoveHandler($this);
                break;
            default:
                break;
        }

        return $handler;
    }
}