<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 16.06.2015
 * Time: 13:05
 */

namespace Users;


class UserEditHandler extends RequestHandler {

    public function handle() {
        if ($this->request->getMethod() != PUT) {
            $response = new Response(400);
            $response->setError(true, "Invalid request");
            return $response;
        }

        $id = (int)$this->request->getResourceId();
        $login = $this->request->getParam('login');
        $passwd = $this->request->getParam('passwd');
        $email = $this->request->getParam('email');
        $name = $this->request->getParam('name');
        $status = (bool)json_decode($this->request->getParam('status'));

        if (!$id) {
            $response = new Response(400);
            $response->setError(true, "No user selected");
            return $response;
        }

        $u = UserStore::findById($id);
        if (!$u) {
            $response = new Response(404);
            $response->setError(true, "User is not found");
            return $response;
        }

        $errorMsg = "";
        if (!User::isValidLogin($login)) {
            $errorMsg = "Invalid login";
        } elseif (!User::isValidPasswd($passwd)) {
            $errorMsg = "Invalid password";
        } elseif (!User::isValidEmail($email)) {
            $errorMsg = "Invalid email";
        } elseif (!User::isValidName($passwd)) {
            $errorMsg = "Invalid name";
        }

        $existDupplicate = false;
        $foundByLogin = UserStore::findByLogin($login);
        if (!$existDupplicate && $foundByLogin && ($foundByLogin->getId() != $u->getId())) {
            $existDupplicate = true;
            $errorMsg = "Such login is already registered";
        }
        $foundByEmail = UserStore::findByEmail($email);
        if (!$existDupplicate && $foundByEmail && ($foundByEmail->getId() != $u->getId())) {
            $existDupplicate = true;
            $errorMsg = "Such email is already registered";
        }
        $foundByName = UserStore::findByName($name);
        if (!$existDupplicate && $foundByName && ($foundByName->getId() != $u->getId())) {
            $existDupplicate = true;
            $errorMsg = "Such name is already registered";
        }

        if (!$errorMsg) {
            $u->setLogin($login);
            $u->setPasswd($passwd);
            $u->setEmail($email);
            $u->setName($name);
            $u->setStatus($status);

            UserStore::write($u);
            $response = new Response(201, $u->toStdClass());
        } else {
            $response = new Response(400);
            $response->setError(true, $errorMsg);
        }

        return $response;
    }
}