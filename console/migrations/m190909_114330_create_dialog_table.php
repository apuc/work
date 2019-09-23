<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dialog}}`.
 */
class m190909_114330_create_dialog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dialog', [
            'id' => $this->primaryKey(),
            'owner' => $this->integer(),
            'status' => $this->tinyInteger()->defaultValue(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('dialog');
    }
}
