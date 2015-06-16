<?php
/**
 * Created by PhpStorm.
 * User: Yarsoniy
 * Date: 15.06.2015
 * Time: 19:08
 */

namespace Users;


abstract class RequestHandler
{
    protected $request;

    abstract public function handle();

    public function __construct(ResourceRequest $request) {
        $this->request = $request;
    }
}