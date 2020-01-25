<?php


namespace App\Controllers;


use App\Contracts\Hasher;

class HomeController
{
    public function __construct(Hasher $hasher) { }
}
