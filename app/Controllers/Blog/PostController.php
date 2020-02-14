<?php


namespace App\Controllers\Blog;


use App\Dto\Blog\UpdatePostDto;
use App\Dto\Blog\CreatePostDto;
use App\Dto\Blog\SearchPostsDto;
use App\Controllers\ApiController;
use App\Services\Blog\PostService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends ApiController
{
    protected PostService $postService;

    /**
     * PostController constructor.
     *
     * @param  \App\Services\Blog\PostService  $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }


    public function get(Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $perPage = $request->query->get('perPage', 4);

        return $this->ok($this->postService->get($page, $perPage));
    }

    public function getPopular(Request $request): Response
    {
        return $this->ok($this->postService->getPopular($request->query->get('count', 5)));
    }

    public function getOne(int $id): Response
    {
        try {
            return $this->ok($this->postService->getOne($id));
        }catch (ModelNotFoundException $e) {
            return $this->notFound(['message' => 'Post not found']);
        }
    }

    public function search(SearchPostsDto $data, Request $request): Response
    {
        $posts = $this->postService->search($data);

        return $this->ok($posts);
    }

    public function create(CreatePostDto $data, Request $request): Response
    {
        $post = $this->postService->create($data, $request->attributes->get('user'));

        return $this->created($post);
    }

    public function update(int $id, UpdatePostDto $data): Response
    {
        $updated = $this->postService->update($id, $data);

        return $this->ok($updated);
    }

    public function delete(int $id): void
    {
        $this->postService->delete($id);
        $this->noContent();
    }

}
