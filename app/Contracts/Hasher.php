<?php


namespace App\Contracts;


interface Hasher
{
    public function hash(string $password): string;

    public function verify(string $hash, string $password): bool;

    public function needsRehash(string $hash): bool;
}
