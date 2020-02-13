<?php


namespace App\Dto;


use App\Core\BaseDto;
use App\Models\Subject;

class ContactDto extends BaseDto
{
    public function validate(): array
    {
        return [
            'name' => 'required|min:1|max:70',
            'surname' => 'required|min:1|max:70',
            'email' => 'required|email|max:150',
            'message' => 'required|min:1|max:500',
            'subject' => [
                'required', 'number',
                static function ($value) {
                    if(!Subject::query()->where('id', '=', $value)->exists()) {
                        return 'Subject is not valid';
                    }
                    return true;
                }
            ]
        ];
    }
}
