<?php


namespace App\Services\Blog;


use App\Models\User;
use App\Core\Redis\Redis;
use App\Dto\Blog\CreatePostDto;
use App\Dto\Blog\UpdatePostDto;
use App\Dto\Blog\SearchPostsDto;

class PostService
{
    public function __construct(Redis $redis)
    {
    }

    public function get(int $page, int $perPage)
    {

    }

    public function getPopular(int $count)
    {

    }

    public function search(SearchPostsDto $data)
    {

    }

    public function create(CreatePostDto $data, User $user)
    {

    }

    public function update(int $id, UpdatePostDto $data)
    {

    }

    public function delete(int $id)
    {

    }
}
