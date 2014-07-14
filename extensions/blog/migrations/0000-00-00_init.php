<?php

return [

    'up' => function() use ($app) {

        $util = $app['db']->getUtility();

        if ($util->tableExists('@blog_post') === false) {
            $util->createTable('@blog_post', function($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('user_id', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('slug', 'string', ['length' => 255]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('status', 'smallint');
                $table->addColumn('date', 'datetime', ['notnull' => false]);
                $table->addColumn('modified', 'datetime');
                $table->addColumn('content', 'text');
                $table->addColumn('excerpt', 'text');
                $table->addColumn('is_commentable', 'boolean', ['notnull' => false]);
                $table->addColumn('num_comments', 'integer', ['default' => 0]);
                $table->addColumn('last_comment_at', 'datetime', ['notnull' => false]);
                $table->addColumn('data', 'json_array', ['notnull' => false]);
                $table->addColumn('roles', 'simple_array', ['notnull' => false]);
                $table->setPrimaryKey(['id']);
                $table->addUniqueIndex(['slug'], 'POSTS_SLUG');
                $table->addIndex(['title'], 'TITLE');
                $table->addIndex(['user_id'], 'USER_ID');
            });
        }

        if ($util->tableExists('@blog_comment') === false) {
            $util->createTable('@blog_comment', function($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('parent_id', 'integer', ['unsigned' => true, 'length' => 10]);
                $table->addColumn('thread_id', 'integer', ['unsigned' => true, 'length' => 10]);
                $table->addColumn('user_id', 'string', ['length' => 255]);
                $table->addColumn('author', 'string', ['length' => 255]);
                $table->addColumn('email', 'string', ['length' => 255]);
                $table->addColumn('url', 'string', ['length' => 255, 'notnull' => false]);
                $table->addColumn('ip', 'string', ['length' => 255]);
                $table->addColumn('created', 'datetime');
                $table->addColumn('content', 'text');
                $table->addColumn('status', 'smallint');
                $table->addColumn('depth', 'smallint');
                $table->setPrimaryKey(['id']);
                $table->addIndex(['status'], 'STATUS');
                $table->addIndex(['created'], 'CREATED');
                $table->addIndex(['thread_id'], 'THREAD_ID');
                $table->addIndex(['author'], 'AUTHOR');
                $table->addIndex(['thread_id', 'status'], 'THREAD_ID_STATUS');
            });
        }
    }

];
