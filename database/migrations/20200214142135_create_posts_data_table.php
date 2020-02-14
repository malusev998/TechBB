<?php

use Phinx\Migration\AbstractMigration;

class CreatePostsDataTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('posts_data', ['signed' => false])
            ->addColumn('post_id', 'integer', ['signed' => false])
            ->addColumn('user_left', 'datetime', ['null' => true])
            ->addColumn('user_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('browser', 'string', ['limit' => 1000, 'null' => true])
            ->addColumn(
                'browser_type',
                'enum',
                ['null' => true, 'values' => ['chrome', 'firefox', 'edge', 'ie', 'unknown', 'safari']   ]
            )
            ->addTimestamps()
            ->create();
    }
}
