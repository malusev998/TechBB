<?php


namespace App\Dto;


use App\Core\BaseDto;

class SubscriberDto extends BaseDto
{
    protected array $allowed = [
        'name',
        'email',
    ];

    public function validate(): array
    {
        return [
            'name'  => 'required|min:1',
            'email' => 'required|email|max:150',
        ];
    }
}
