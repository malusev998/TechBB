<?php


namespace App\Controllers;


use App\Contracts\Hasher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends ApiController
{
    public function __construct(Hasher $hasher) { }

    public function index(): void
    {
        echo 1;
    }

    public function singlePost(Request $request, $name)
    {
        return $this->ok(['name' => $name]);
    }
}
