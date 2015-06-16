<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 16.06.2015
 * Time: 13:05
 */

namespace Users;


class UserGetHandler extends RequestHandler {

    public function handle() {
        $userId = $this->request->getResourceId();

        $u = new User();
        $u->setId($userId);
        UserStore::read($u);

        if ($u->getId()) {
            $response = new Response(200, $u->toStdClass());
        } else {
            $response = new Response(404);
            $response->setError(true, "User is not found");
        }

        return $response;
    }
}