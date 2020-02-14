<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Carbon\Carbon;
use Phinx\Seed\AbstractSeed;
use App\Services\ArgonHasher;
use BrosSquad\DotEnv\EnvParser;

class UserSeeder extends AbstractSeed
{
    public function run(): void
    {
        $hasher = new ArgonHasher(
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );
        $dotnev = new EnvParser(__DIR__.'/../../.env');
        $dotnev->parse();
        $envs = $dotnev->getEnvs();

        $roles = explode(',', $envs['ROLES']);

        $data = [];

        foreach ($roles as $role) {
            $data[] = [
                'name'       => $role,
                'created_at' => Carbon::now('UTC'),
                'updated_at' => Carbon::now('UTC'),
            ];
        }

        $this->table('roles')
            ->insert($data)
            ->saveData();

        $adapter = $this->getAdapter();
        $admin = $adapter->fetchRow('SELECT id FROM roles WHERE name = \'admin\' LIMIT 1');
        $user = $adapter->fetchRow('SELECT id FROM roles WHERE name = \'user\' LIMIT 1');

        echo $envs['ADMIN_PASSWORD'] . PHP_EOL;

        $data = [
            [
                'name'              => $envs['ADMIN_NAME'],
                'surname'           => $envs['ADMIN_SURNAME'],
                'email'             => $envs['ADMIN_EMAIL'],
                'password'          => $hasher->hash($envs['ADMIN_PASSWORD']),
                'email_verified_at' => Carbon::now('UTC'),
                'created_at'        => Carbon::now('UTC'),
                'updated_at'        => Carbon::now('UTC'),
                'role_id'           => $admin['id'],
            ],
        ];

        $this->table('users')
            ->insert($data)
            ->saveData();
    }
}
