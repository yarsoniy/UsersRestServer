<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 16.06.2015
 * Time: 13:05
 */

namespace Users;


class UserRemoveHandler extends RequestHandler {

    public function handle() {
        if ($this->request->getMethod() != DELETE) {
            $response = new Response(400);
            $response->setError(true, "Invalid request");
            return $response;
        }

        $id = (int)$this->request->getResourceId();

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

        UserStore::remove($u);
        $response = new Response(200);
        return $response;
    }
}