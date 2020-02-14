<?php


namespace App\Services\Auth;


use App\Models\User;
use App\Dto\Auth\LoginDto;
use App\Contracts\Hasher;
use App\Contracts\Auth\LoginContract;
use App\Contracts\Jwt\JwtCreator;
use Psr\Container\ContainerInterface;
use App\Exceptions\InvalidCredentialsException;

class LoginService implements LoginContract
{
    private Hasher $hasher;
    private JwtCreator $jwtCreator;
    private ContainerInterface $container;

    /**
     * LoginService constructor.
     *
     * @param  \App\Contracts\Hasher  $hasher
     * @param  \App\Contracts\Jwt\JwtCreator  $jwtCreator
     * @param  \Psr\Container\ContainerInterface  $container
     */
    public function __construct(Hasher $hasher, JwtCreator $jwtCreator, ContainerInterface $container)
    {
        $this->hasher = $hasher;
        $this->jwtCreator = $jwtCreator;
        $this->container = $container;
    }


    /**
     * @throws \App\Exceptions\InvalidCredentialsException
     * @throws \Throwable
     *
     * @param  \App\Dto\Auth\LoginDto  $data
     *
     * @return array
     */
    public function login(LoginDto $data): array
    {
        /** @var User $user */
        $user = User::query()
            ->where('email', '=', $data->email)
            ->firstOrFail();

        if(!$this->hasher->verify($user->password, $data->password)) {
            throw new InvalidCredentialsException();
        }

        if($this->hasher->needsRehash($user->password)) {
            $user->password = $this->hasher->hash($data->password);
            $user->saveOrFail();
        }

        return [
            'token' => $this->jwtCreator->create($user),
            'expires' => $this->container->get('expires_at')->totalMinutes,
            'type' => 'Bearer',
            'payload' => $user->getCustomClaims()
        ];
    }
}
