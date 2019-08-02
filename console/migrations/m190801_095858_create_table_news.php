<?php

use yii\db\Migration;

/**
 * Class m190801_095858_create_table_news
 */
class m190801_095858_create_table_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->text()->notNull(),
            'description' => $this->text(),
            'content' => $this->text()->notNull(),
            'status' => $this->integer(1),
            'dt_create' => $this->integer(11),
            'dt_update' => $this->integer(11),
            'dt_public' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('news');
    }
}
