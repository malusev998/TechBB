<?php

use Phinx\Migration\AbstractMigration;

class CreateNewslettersTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('subscribers', ['signed' => false])
            ->addColumn('name', 'string', ['limit' => 150, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 150, 'null' => false])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->create();
    }
}
