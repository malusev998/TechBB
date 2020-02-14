<?php

use Phinx\Migration\AbstractMigration;

class CreateSubscribersTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('subscribers', ['signed' => false])
            ->addColumn('name', 'string', ['limit' => 80, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 150, 'null' => false])
            ->addTimestamps()
            ->addIndex('email', ['unique' => true])
            ->create();
    }
}
