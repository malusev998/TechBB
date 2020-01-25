<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('users', ['signed' => false])
            ->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('surname', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('email', 'string', ['limit' => 150])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('email_verified_at', 'datetime', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addIndex('email', ['unique' => true])
            ->create();
    }
}
