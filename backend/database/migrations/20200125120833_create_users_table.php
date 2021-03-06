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
            ->addColumn('role_id', 'integer', ['signed' => false])
            ->addIndex('email', ['unique' => true])
            ->addForeignKey('role_id', 'roles', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->addTimestamps()
            ->create();
    }
}
