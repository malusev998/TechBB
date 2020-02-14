<?php


namespace App\Dto\Blog;


use App\Core\BaseDto;

class CreatePostDto extends BaseDto
{
    protected array $allowed = [
        'title',
        'description',
        'status',
        'categories'
    ];

    public function validate(): array
    {
        return [
            'title' => 'required|min:2|max:150|string',
            'description' => 'required|min:1|max:2000|string',
            'status' => 'required',
            'categories' => ''
        ];
    }
}
