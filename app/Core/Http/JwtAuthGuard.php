<?php


namespace App\Core\Http;


use Throwable;
use App\Models\User;
use App\Core\Contracts\AuthGuard;
use App\Contracts\Jwt\JwtChecker;
use Symfony\Component\HttpFoundation\Request;

class JwtAuthGuard implements AuthGuard
{
    protected JwtChecker $jwtChecker;

    public function __construct(JwtChecker $jwtChecker) {
        $this->jwtChecker = $jwtChecker;
    }

    public function authenticate(Request $request): ?Request
    {
        $token = $request->headers->get('Authorization');

        if($token === null) {
            return null;
        }

        try {
            ['payload' => $payload] = $this->jwtChecker->check($token);

            $user = User::query()->where('email', '=', $payload['email'])->firstOrFail();

            $request->attributes->set('user', $user);

        } catch (Throwable $e) {
            return null;
        }

        return $request;
    }
}
