<?php

use Phinx\Migration\AbstractMigration;

class CreateRolesTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('roles', ['signed' => false])
            ->addColumn('name', 'string',  ['limit' => 20])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addIndex('name', ['unique' => true])
            ->create();
    }
}
