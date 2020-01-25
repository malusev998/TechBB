<?php

use Phinx\Migration\AbstractMigration;

class CreateRolesTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('roles')
            ->addColumn('name', 'string',  ['limit' => 20])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addIndex('name', ['unique' => true])
            ->create();

        $this->table('users')
            ->addColumn('role_id', 'integer', ['signed' => true])
            ->addForeignKey('role_id', 'roles', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])->save();
    }
}
