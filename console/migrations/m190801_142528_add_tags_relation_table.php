<?php

use yii\db\Migration;

/**
 * Class m190801_142528_add_tags_relation_table
 */
class m190801_142528_add_tags_relation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tags_relation', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer(11)->notNull(),
            'tags_id' => $this->integer(11)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('tags_relation');
    }
}
