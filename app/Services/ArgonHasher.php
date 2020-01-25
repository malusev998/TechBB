<?php


namespace App\Services;


use App\Contracts\Hasher;

class ArgonHasher implements Hasher
{
    private int $opsLimit;
    private int $memLimit;

    /**
     * ArgonHasher constructor.
     *
     * @param  int  $opsLimit
     * @param  int  $memLimit
     */
    public function __construct(int $opsLimit, int $memLimit)
    {
        $this->opsLimit = $opsLimit;
        $this->memLimit = $memLimit;
    }


    public function hash(string $password): string
    {
        return sodium_crypto_pwhash_str($password, $this->opsLimit, $this->memLimit);
    }

    public function verify(string $hash, string $password): bool
    {
        return sodium_crypto_pwhash_str_verify($hash, $password);
    }

    public function needsRehash(string $hash): bool
    {
        return sodium_crypto_pwhash_str_needs_rehash($hash, $this->opsLimit, $this->memLimit);
    }
}
