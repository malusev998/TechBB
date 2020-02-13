<?php

use Phinx\Migration\AbstractMigration;

class CreatePostsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('posts', ['signed' => false])
            ->addColumn('title', 'string', ['limit' => 200])
            ->addColumn('description', 'string', ['limit' => 2000])
            ->addColumn('status', 'enum', ['values' => ['published', 'draft']])
            ->addColumn('number_of_likes', 'integer', ['signed' => false, 'default' => 0])
            ->addColumn('number_of_comments', 'integer', ['signed' => false, 'default' => 0])
            ->addColumn('user_id', 'integer', ['signed' => true, 'null' => true])
            ->addTimestamps()
            ->addIndex('title', ['unique' => true])
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'delete' => 'set null',
                    'update' => 'cascade',
                ]
            )
            ->create();
    }
}
