<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%action}}`.
 */
class m200312_113830_create_action_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%action}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'subject' => $this->string(),
            'subject_id' => $this->integer(),
            'count' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%action}}');
    }
}
