<?php


namespace App\Services\Blog;


use Throwable;
use App\Models\User;
use App\Models\Category;
use App\Core\Redis\Redis;
use Carbon\CarbonInterval;
use Illuminate\Database\Capsule\Manager;

class CategoryService
{
    protected Redis $redis;
    protected Manager $manager;

    public function __construct(Redis $redis, Manager $manager)
    {
        $this->redis = $redis;
        $this->manager = $manager;
    }

    public function get(int $page, int $perPage)
    {
        $connection = $this->redis->getConnection();
        $key = "categories:{$page}:{$perPage}";
        if (($data = $connection->get($key))) {
            return $data;
        }

        $categories = Category::query()->paginate($perPage, ['*'], 'page', $page);

        $connection->setex($key, CarbonInterval::minutes(15)->totalSeconds, $categories);

        return $categories;
    }

    public function getPopular(int $count)
    {
        $connection = $this->redis->getConnection();
        if (($data = $connection->get('popular_categories'))) {
            return $data;
        }

        $categories = Category::query()
            ->orderByDesc('number_of_posts')
            ->limit($count);
        $connection->setex('popular_categories', CarbonInterval::hour(1)->seconds, $categories,);

        return $categories;
    }

    public function getOne(int $id)
    {
        return Category::query()->findOrFail($id);
    }

    public function create(User $user)
    {
    }

    public function update(int $id)
    {
    }

    public function delete(int $id)
    {
        return Category::query()->where('id', '=', $id)->delete();
    }

    /**
     * @throws \Exception
     */
    public function calculateNumberOfPosts(): void
    {
        $connection = $this->manager->getConnection();
        $data = $connection->query()
            ->selectRaw('COUNT(post_id) as count')
            ->addSelect('category_id')
            ->from('category_posts')
            ->groupBy('category_id')
            ->cursor();

        $connection->beginTransaction();

        try {
            $data->each(
                static function ($item) {
                    Category::query()->where('id', '=', $item->category_id)->update(
                        [
                            'number_of_posts' => $item->count,
                        ]
                    );
                }
            );
            $connection->commit();
        } catch (Throwable $e) {
            $connection->rollBack();
        }
    }
}
