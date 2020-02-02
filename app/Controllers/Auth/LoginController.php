<?php


namespace App\Controllers\Auth;


use App\Dto\LoginDto;
use App\Contracts\LoginContract;
use App\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends ApiController
{
    protected LoginContract $loginService;

    /**
     * LoginController constructor.
     *
     * @param  \App\Contracts\LoginContract  $loginService
     */
    public function __construct(LoginContract $loginService)
    {
        $this->loginService = $loginService;
    }


    public function login(LoginDto $loginDto, Request $request)
    {
    }
}
