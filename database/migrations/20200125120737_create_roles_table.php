<?php

use Phinx\Migration\AbstractMigration;

class CreateRolesTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('roles', ['signed' => false])
            ->addColumn('name', 'string',  ['limit' => 20])
            ->addIndex('name', ['unique' => true])
            ->addTimestamps()
            ->create();
    }
}
