<?php


namespace App\Dto\Blog;


use App\Core\BaseDto;

class SearchPostsDto extends BaseDto
{
    protected array $allowed = [
        'term',
        'orderBy',
        'categories',
        'page',
        'perPage'
    ];

    public function validate(): array
    {
        return [
            'term'              => 'required|min:3|max:150',
            'orderBy'           => '',
            'orderBy.field'     => 'required',
            'orderBy.direction' => 'required',
            'categories'        => 'numeric',
        ];
    }
}
