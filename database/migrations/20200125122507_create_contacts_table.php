<?php

use Phinx\Migration\AbstractMigration;

class CreateContactsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('contacts', ['singed' => false])
            ->addColumn('name', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('surname', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 150, 'null' => false])
            ->addColumn('message', 'string', ['limit' => 500, 'null' => false])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();
    }
}
