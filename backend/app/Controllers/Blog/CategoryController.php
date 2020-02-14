<?php


namespace App\Controllers\Blog;


use App\Controllers\ApiController;
use App\Services\Blog\CategoryService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends ApiController
{
    protected CategoryService $categoryService;

    /**
     * CategoryController constructor.
     *
     * @param  \App\Services\Blog\CategoryService  $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function get(Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $perPage = $request->query->get('perPage', 15);
        return $this->ok($this->categoryService->get($page, $perPage));
    }

    public function getPopular(Request $request): Response
    {
        return $this->ok($this->categoryService->getPopular($request->query->get('count', 5)));
    }

    public function getOne(int $id): Response
    {
        try {
            return $this->ok($this->categoryService->getOne($id));
        } catch (ModelNotFoundException $e) {
            return $this->badRequest(['message' => 'Category is not found']);
        }
    }

    public function create(Request $request): Response
    {
    }

    public function update(Request $request): Response
    {
    }

    public function delete(int $id): Response
    {
        $this->categoryService->delete($id);
        return $this->noContent();
    }

}
