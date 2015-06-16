<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 16.06.2015
 * Time: 13:05
 */

namespace Users;


class UserListHandler extends RequestHandler {

    public function handle() {
        $users = UserStore::getAll();

        $clientData = array();
        foreach ($users as $u) {
            $item = $u->toStdClass();
            $clientData[] = $item;
        }

        $response = new Response(200, $clientData);
        return $response;
    }
}