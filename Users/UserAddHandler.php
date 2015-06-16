<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 16.06.2015
 * Time: 13:05
 */

namespace Users;


class UserAddHandler extends RequestHandler {

    public function handle() {
        if ($this->request->getMethod() != POST) {
            $errorMsg = "Invalid request";
            $response = new Response(400);
            $response->setError(true, $errorMsg);
            return $response;
        }

        $login = $this->request->getParam('login');
        $passwd = $this->request->getParam('passwd');
        $email = $this->request->getParam('email');
        $name = $this->request->getParam('name');
        $status = (bool)json_decode($this->request->getParam('status'));

        $errorMsg = "";

        if (!User::isValidLogin($login)) {
            $errorMsg = "Invalid login";
        } elseif (!User::isValidPasswd($passwd)) {
            $errorMsg = "Invalid password";
        } elseif (!User::isValidEmail($email)) {
            $errorMsg = "Invalid email";
        } elseif (!User::isValidName($passwd)) {
            $errorMsg = "Invalid name";
        } elseif (UserStore::findByLogin($login)) {
            $errorMsg = "Such login is already registered";
        } elseif (UserStore::findByEmail($email)) {
            $errorMsg = "Such email is already registered";
        } elseif (UserStore::findByName($name)) {
            $errorMsg = "Such name is already registered";
        }

        if (!$errorMsg) {
            $u = new User();
            $u->setLogin($login);
            $u->setPasswd($passwd);
            $u->setEmail($email);
            $u->setName($name);
            $u->setStatus($status);

            UserStore::write($u);
            $response = new Response(201, $u->toStdClass());
        } else {
            $response = new Response(404);
            $response->setError(true, $errorMsg);
        }

        return $response;
    }
}