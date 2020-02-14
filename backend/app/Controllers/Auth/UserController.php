<?php


namespace App\Controllers\Auth;


use App\Controllers\ApiController;
use App\Core\Annotations\Authenticate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{
    /**
     * @Authenticate(guard="default")
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(Request $request): Response
    {
        return $this->ok($request->attributes->get('user'));
    }

}
