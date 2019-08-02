<?php

use yii\db\Migration;

/**
 * Class m190801_140937_add_table_tags
 */
class m190801_140937_add_table_tags extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tags', [
            'id' => $this->primaryKey(),
            'tag' => $this->string(255)->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tags');
    }
}
