<?php

use yii\db\Migration;

/**
 * Class m190722_130444_add_subject_to_send_queue_table
 */
class m190722_130444_add_subject_to_send_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('send_queue', 'subject', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('send_queue', 'subject');
    }
}
