<?php


namespace App\Dto;


use App\Core\BaseDto;

class SubjectDto extends BaseDto
{
    protected array $allowed = ['name'];

    public function validate(): array
    {
        return [
            'name' => 'required|min:2|max:150'
        ];
    }
}
