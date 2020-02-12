<?php


namespace App\Controllers\Auth;


use Throwable;
use App\Dto\Auth\RegisterDto;
use App\Controllers\ApiController;
use App\Contracts\Auth\RegisterContract;
use App\Exceptions\UserAlreadyExistsException;

class RegisterController extends ApiController
{
    private RegisterContract $register;

    public function __construct(RegisterContract $register)
    {
        $this->register = $register;
    }

    public function register(RegisterDto $data)
    {
        try {
            $user = $this->register->register($data);

            return $this->ok(
                [
                    'message' => 'Your account has been created, check your email to verify it',
                    'user'    => $user,
                ]
            );
        }catch (UserAlreadyExistsException $e) {
            return $this->badRequest(['message' => $e->getMessage()]);
        }
        catch (Throwable $e) {
            return $this->serverError(['message' => 'An error has occurred']);
        }
    }
}
