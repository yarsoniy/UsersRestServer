<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 15.06.2015
 * Time: 19:05
 */

namespace Users;


class Database {
    private static $instance;

    private $connection;

    private $dsn = "mysql:host=localhost;dbname=users;charset=latin1";
    private $user = 'user_app';
    private $pass = 'mypass';

    private function __construct(){
        $this->connection = new \PDO($this->dsn, $this->user, $this->pass);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function fetchObjects($sql, $params = array()) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function execute($sql, $params = array()) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

}