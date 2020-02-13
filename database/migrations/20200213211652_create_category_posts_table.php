<?php

use Phinx\Migration\AbstractMigration;

class CreateCategoryPostsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('category_posts', ['primary_key' => ['post_id', 'category_id'], 'id' => false])
            ->addColumn('post_id', 'integer', ['signed' => false])
            ->addColumn('category_id', 'integer', ['signed' => false])
            ->addForeignKey(
                'post_id',
                'posts',
                'id',
                [
                    'delete'  => 'cascade',
                    'cascade' => 'cascade',
                ]
            )
            ->addForeignKey(
                'category_id',
                'categories',
                'id',
                [
                    'delete'  => 'cascade',
                    'cascade' => 'cascade',
                ]
            )
            ->create();
    }
}
