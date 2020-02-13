<?php


namespace App\Controllers;


use App\Core\Annotations\Middleware;

class HomeController extends ApiController
{
    /**
     * @Middleware(middleware={"cors"})
     */
    public function index()
    {
        return $this->ok([]);
    }
}
