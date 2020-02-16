<?php


namespace App\Services\Blog;


use App\Models\User;
use App\Models\Post;
use App\Core\Redis\Redis;
use App\Models\PostsData;
use Carbon\CarbonInterval;
use App\Dto\Blog\CreatePostDto;
use App\Dto\Blog\UpdatePostDto;
use App\Dto\Blog\SearchPostsDto;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class PostService
{
    protected Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function get(int $page, int $perPage, $category = null)
    {
        $connection = $this->redis->getConnection();

        $key = "posts:{$page}:{$perPage}".($category !== null ? ":$category" : '');


        if (($data = $connection->get($key))) {
            return $data;
        }

        $posts = Post::with(
            [
                'categories' => static function (BelongsToMany $builder) use ($category) {
                    if ($category) {
                        $builder = $builder->where('id', '=', $category);
                    }
                    return $builder->select(['id', 'name', 'number_of_posts']);
                },
                'user'       => static function (BelongsTo $builder) {
                    return $builder->select('id', 'name', 'surname', 'email');
                },
            ]
        )
            ->where('status', 'published')
            ->paginate($perPage, ['*'], 'page', $page);


        $connection->setex($key, CarbonInterval::hour()->totalSeconds, $posts);

        return $posts;
    }

    public function getPopular(int $count)
    {
        $connection = $this->redis->getConnection();
        // Most visits on post desc in last month, user left - created_at > 30 seconds
        if (PostsData::query()->count() > 0) {
            // TODO: needs testing and some bug fixes
            $data = PostsData::query()
                ->orderByDesc('COUNT(post_id)')
                ->whereNotNull('user_left')
                // FIXME: fix here
                ->where('user_left - created_at', '>', CarbonInterval::seconds(30)->totalSeconds)
                ->groupBy('post_id')
                ->limit($count)
                ->get();

            $posts = Post::with($this->with())
                ->whereIn('id', '=', $data->pluck('post_id'))
                ->where('status', '=', 'published')
                ->get();
        } else {
            $posts = Post::with(($this->with()))
                ->where('status', '=', 'published')
                ->orderByDesc('created_at')
                ->orderByDesc('number_of_likes')
                ->orderByDesc('number_of_comments')
                ->limit($count)
                ->get();
        }


        $connection->setex('posts:popular', CarbonInterval::hour()->totalSeconds, $posts);

        return $posts;
    }

    public function getOne(int $id)
    {
        return Post::with($this->with())
            ->where('id', $id)
            ->where('status', 'published')
            ->firstOrFail();
    }

    public function search(SearchPostsDto $data)
    {
        $builder = Post::with($this->with());

        $builder->where('title', 'LIKE', $data->term);

        $builder->orderByDesc('created_at');

        if (isset($data->orderBy)) {
            $builder->orderBy($data->orderBy->column, $data->orderBy->direction);
        }

        return $builder->paginate($data->perPage, ['*'], 'page', $data->page);
    }

    private function with(): array
    {
        return [
            'user'       => static function (BelongsTo $builder) {
                return $builder->select(['id', 'name', 'surname', 'email']);
            },
            'categories' => static function (BelongsToMany $builder) {
                return $builder->select(['id', 'name', 'number_of_posts']);
            },
        ];
    }

    /**
     * @throws \Throwable
     *
     * @param  \App\Models\User  $user
     * @param  \App\Dto\Blog\CreatePostDto  $data
     *
     * @return \App\Models\Post
     */
    public function create(CreatePostDto $data, User $user): Post
    {
        $post = new Post(
            [
                'title'              => $data->title,
                'status'             => $data->status,
                'description'        => $data->description,
                'number_of_likes'    => 0,
                'number_of_comments' => 0,
                'user_id'            => $user->getIdentifier(),
            ]
        );

        $post->saveOrFail();

        $categories = $data->categories ?? [];

        $post->categories()->attach($categories);

        return $post;
    }

    public function update(int $id, UpdatePostDto $data)
    {
    }

    public function delete(int $id)
    {
        return Post::query()->where('id', '=', $id)->delete();
    }
}
