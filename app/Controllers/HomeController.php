<?php


namespace App\Controllers;


use App\Contracts\Hasher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function __construct(Hasher $hasher) { }

    public function index(): void
    {
        echo 1;
    }

    public function singlePost(Request $request, $name)
    {
        return Response::create(json_encode(['name' => $name]), 201, ['Content-Type' => 'application/json']);
    }
}
