<?php


namespace App\Controllers\Auth;


use Throwable;
use App\Dto\Auth\LoginDto;
use App\Contracts\Auth\LoginContract;
use App\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends ApiController
{
    protected LoginContract $loginService;

    /**
     * LoginController constructor.
     *
     * @param  \App\Contracts\Auth\LoginContract  $loginService
     */
    public function __construct(LoginContract $loginService)
    {
        $this->loginService = $loginService;
    }


    /**
     * @param  \App\Dto\Auth\LoginDto  $loginDto
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function login(LoginDto $loginDto): ?Response
    {
        try {
            $data = $this->loginService->login($loginDto);
            return $this->ok($data);
        }catch (Throwable $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}
