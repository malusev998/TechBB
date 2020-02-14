<?php


use Faker\Factory;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Phinx\Seed\AbstractSeed;
use App\Console\ConsoleKernel;
use BrosSquad\DotEnv\EnvParser;

class PostsSeeder extends AbstractSeed
{
    public function run(): void
    {
        $dotnev = new EnvParser(__DIR__.'/../../.env');
        $dotnev->parse();
        $dotnev->loadIntoENV();
        $dotnev->loadUsingPutEnv();
        (new ConsoleKernel())->run();

        $users = User::all(['id'])->pluck('id')->toArray();
        $categories = Category::all(['id'])->pluck('id')->toArray();

        $faker = Factory::create();

        for ($i = 0; $i < 10_000; $i++) {
            try {
                $post = new Post(
                    [
                        'title'              => $faker->unique()->realText(random_int(50, 140)),
                        'description'        => $faker->text(random_int(350, 1500)),
                        'status'             => $faker->randomElement(['published', 'draft']),
                        'user_id'            => $users[random_int(0, count($users) - 1)],
                        'number_of_likes'    => random_int(1, 10000),
                        'number_of_comments' => random_int(1, 100),
                    ]
                );
                $post->saveOrFail();

                $post->categories()->attach($faker->randomElement($categories));

            } catch (Throwable $e) {
                echo $e->getMessage().PHP_EOL;
            }
        }
    }
}
