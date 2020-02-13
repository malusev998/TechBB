<?php

use Phinx\Migration\AbstractMigration;

class CreateCategoriesTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('categories', ['signed' => false])
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('number_of_posts', 'integer', ['default' => 0, 'null' => false, 'signed' => false])
            ->addColumn('user_id', 'integer', ['signed' => false, 'null' => true])
            ->addIndex('name', ['unique' => true])
            ->addTimestamps()
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'delete' => 'set null',
                    'update' => 'cascade',
                ]
            )->create();
    }
}
