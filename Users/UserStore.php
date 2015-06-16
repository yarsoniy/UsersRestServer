<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 16.06.2015
 * Time: 14:01
 */

namespace Users;


class UserStore {

    private function __construct() {}

    public static function getAll() {
        $query = "
        SELECT
          id,
          login,
          passwd,
          email,
          `name`,
          status
        FROM testusers
        ";
        $dbResult = Database::getInstance()->fetchObjects($query);
        $result = array();
        foreach ($dbResult as $dbRow) {
            $result[] = new User($dbRow);
        }
        return $result;
    }

    public static function read(User $u) {
        if (!$u->isNew()) {
            $query = "
            SELECT
              login,
              passwd,
              email,
              `name`,
              status
            FROM testusers
            WHERE
              testusers.id = :id
            ";
            $params = array(':id' => $u->getId());
            $dbResult = Database::getInstance()->fetchObjects($query, $params);

            if ($dbResult) {
                $data = $dbResult[0];
                $u->setLogin($data->login);
                $u->setPasswd($data->passwd);
                $u->setEmail($data->email);
                $u->setName($data->name);
                $u->setStatus($data->status);
            } else {
                $u->setId(0);
            }
        }
    }

    public static function write(User $u) {
        $params = array();
        if ($u->isNew()) {
            $query = "
            INSERT INTO testusers (login, passwd, email, name, status) VALUES
            (:login, :passwd, :email, :name, :status)
            ";

        } else {
            $query = "
            UPDATE testusers
            SET
              login = :login,
              passwd = :passwd,
              email = :email,
              `name` = :name,
              status = :status
            WHERE
              id = :id
            ";
            $params[':id'] = $u->getId();
        }
        $params[':login'] = $u->getLogin();
        $params[':passwd'] = $u->getPasswd();
        $params[':email'] = $u->getEmail();
        $params[':name'] = $u->getName();
        $params[':status'] = $u->getStatus();

        Database::getInstance()->execute($query, $params);

        if ($u->isNew()) {
            $id = Database::getInstance()->lastInsertId();
            $u->setId($id);
        }
    }

    public static function remove(User $u) {
        if (!$u->isNew()) {
            $query = "
            DELETE testusers
            FROM testusers
            WHERE
              testusers.id = :id
            ";
            $params = array(':id' => $u->getId());
            Database::getInstance()->execute($query, $params);

            $u->setId(0);
        }
    }

    public static function findById($id) {
        $query = "
            SELECT
              id,
              login,
              passwd,
              email,
              `name`,
              status
            FROM testusers
            WHERE
              testusers.id = :id
            ";
        $params = array(':id' => $id);
        $dbResult = Database::getInstance()->fetchObjects($query, $params);

        $result = null;
        if ($dbResult) {
            $data = $dbResult[0];
            $u = new User($data);
            $result = $u;
        }
        return $result;
    }

    public static function findByLogin($login) {
        $query = "
            SELECT
              id,
              login,
              passwd,
              email,
              `name`,
              status
            FROM testusers
            WHERE
              testusers.login = :login
            ";
        $params = array(':login' => $login);
        $dbResult = Database::getInstance()->fetchObjects($query, $params);

        $result = null;
        if ($dbResult) {
            $data = $dbResult[0];
            $u = new User($data);
            $result = $u;
        }
        return $result;
    }

    public static function findByEmail($email) {
        $query = "
            SELECT
              id,
              login,
              passwd,
              email,
              `name`,
              status
            FROM testusers
            WHERE
              testusers.email = :email
            ";
        $params = array(':email' => $email);
        $dbResult = Database::getInstance()->fetchObjects($query, $params);

        $result = null;
        if ($dbResult) {
            $data = $dbResult[0];
            $u = new User($data);
            $result = $u;
        }
        return $result;
    }

    public static function findByName($name) {
        $query = "
            SELECT
              id,
              login,
              passwd,
              email,
              `name`,
              status
            FROM testusers
            WHERE
              testusers.name = :name
            ";
        $params = array(':name' => $name);
        $dbResult = Database::getInstance()->fetchObjects($query, $params);

        $result = null;
        if ($dbResult) {
            $data = $dbResult[0];
            $u = new User($data);
            $result = $u;
        }
        return $result;
    }
}