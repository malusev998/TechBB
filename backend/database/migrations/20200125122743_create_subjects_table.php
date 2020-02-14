<?php

use Phinx\Migration\AbstractMigration;

class CreateSubjectsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('subjects', ['signed' => false])
            ->addColumn('name', 'string', ['limit' => 150, 'null' => false])
            ->addColumn('user_id', 'integer', ['signed' => false, 'null' => true])
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                ['update' => 'cascade', 'delete' => 'set null']
            )
            ->addIndex('name', ['unique' => true])
            ->addTimestamps()
            ->create();

        $this->table('contacts')
            ->addColumn('subject_id', 'integer', ['signed' => false, 'null' => true])
            ->addForeignKey(
                'subject_id',
                'subjects',
                'id',
                ['update' => 'cascade', 'delete' => 'set null']
            )
            ->save();
    }
}
