<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 16.06.2015
 * Time: 13:33
 */

namespace Users;


class User {
    private $id = 0;
    private $login = '';
    private $passwd = '';
    private $email = '';
    private $name = '';
    private $status = false;

    public function __construct(\stdClass $data = null) {
        if ($data) {
            $this->setId($data->id);
            $this->setLogin($data->login);
            $this->setPasswd($data->passwd);
            $this->setEmail($data->email);
            $this->setName($data->name);
            $this->setStatus($data->status);
        }
    }

    public function toStdClass() {
        $result = new \stdClass();
        $result->id = $this->getId();
        $result->login = $this->getLogin();
        $result->passwd = $this->getPasswd();
        $result->email = $this->getEmail();
        $result->name = $this->getName();
        $result->status = $this->getStatus();

        return $result;
    }

    public function isNew() {
        return $this->id == 0;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id){
        $this->id = (int)$id;
    }

    /**
     * @return string
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login) {
        $this->login = (string)$login;
    }

    /**
     * @return string
     */
    public function getPasswd() {
        return $this->passwd;
    }

    /**
     * @param string $passwd
     */
    public function setPasswd($passwd) {
        $this->passwd = md5((string)$passwd);
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = (string)$email;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = (string)$name;
    }

    /**
     * @return boolean
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status) {
        $this->status = (bool)$status;
    }

    public static function isValidLogin($login) {
        $result = false;
        if ($login) {
            $result = preg_match('/^[a-z\d]*$/', $login);
        }
        return $result;
    }

    public static function isValidPasswd($passwd) {
        if (is_string($passwd) && strlen($passwd) >= 4) {
            return true;
        }
        return false;
    }

    public static function isValidEmail($email) {
        $result = false;
        if ($email) {
            $result = preg_match('/^[a-z\d_]+\.?[a-z\d_]+@[a-z\d_]*\.[a-z]{2,3}$/', $email);
        }
        return $result;
    }

    public static function isValidName($name) {
        $result = false;
        if ($name) {
            $result = preg_match('/^[a-z\d]*$/', $name);
        }
        return $result;
    }
}