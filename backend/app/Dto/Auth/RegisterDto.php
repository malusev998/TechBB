<?php


namespace App\Dto\Auth;


use App\Core\BaseDto;

class RegisterDto extends BaseDto
{
    protected array $allowed = ['name', 'surname', 'email', 'password'];

    public function validate(): array
    {
        return [
            'name' => 'required|min:1|max:70',
            'surname' => 'required|min:1|max:70',
            'email' => 'required|email|max:150',
            'password' => 'required|min:8'
        ];
    }

}
