<?php


namespace App\Core\Contracts;


interface Factory
{
    public function create(?string $type = null);
}
