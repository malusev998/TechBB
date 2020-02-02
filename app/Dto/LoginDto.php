<?php


namespace App\Dto;


use App\Core\BaseDto;

/**
 * Class LoginDto
 *
 * @package App
 * @property string $email
 * @property string $password
 *
 */
class LoginDto extends BaseDto
{
    protected array $allowed = [
        'email', 'password'
    ];

    public function validate(): array
    {
        return [
            'email' => 'required|email|max:150',
            'password' => 'required'
        ];
    }
}
