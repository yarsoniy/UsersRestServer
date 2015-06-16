<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 15.06.2015
 * Time: 18:42
 */

namespace Users;

define('GET', 'GET');
define('POST', 'POST');
define('PUT', 'PUT');
define('DELETE', 'DELETE');

class Application{

    public static function run() {
        $response = null;

        try {
            $request = ResourceRequest::parse();
            if ($request) {
                $handler = $request->createHandler();
                if ($handler) {
                    $response = $handler->handle();
                }
            }

            if (!$response) {
                $response = new Response(400);
                $response->setError(true, "Invalid request");
            }
            $response->respond();

        } catch (\Exception $e){
            $response = new Response(500);
            $response->setError(true, $e->getMessage() . "\n");
            $response->respond();
        }
    }
}