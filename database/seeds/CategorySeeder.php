<?php


use App\Models\User;
use App\Models\Category;
use Phinx\Seed\AbstractSeed;
use App\Console\ConsoleKernel;
use BrosSquad\DotEnv\EnvParser;

class CategorySeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run(): void
    {
        $dotnev = new EnvParser(__DIR__.'/../../.env');
        $dotnev->parse();
        $dotnev->loadIntoENV();
        $dotnev->loadUsingPutEnv();

        (new ConsoleKernel())->run();

        $faker = Faker\Factory::create();
        $users = User::all(['id'])->pluck('id')->toArray();


        for ($i = 0; $i < 50; $i++) {
            try {
                $category = new Category(
                    [
                        'name'    => $faker->unique()->realText(random_int(20, 50)),
                        'user_id' => $users[random_int(0, count($users) - 1)],
                    ]
                );

                $category->saveOrFail();
            } catch (Throwable $e) {
                echo $e->getMessage().PHP_EOL;
            }
        }
    }
}
