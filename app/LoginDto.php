<?php


namespace App;


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
}
