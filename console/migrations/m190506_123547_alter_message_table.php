<?php

use yii\db\Migration;

/**
 * Class m190506_123547_alter_message_table
 */
class m190506_123547_alter_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('message', 'created_at', $this->integer());
        $this->alterColumn('message', 'updated_at', $this->integer());
        $this->alterColumn('message', 'subject', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('message', 'created_at', $this->timestamp());
        $this->alterColumn('message', 'updated_at', $this->timestamp());
        $this->alterColumn('message', 'subject', $this->integer());
    }

}
