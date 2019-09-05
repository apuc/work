<?php

use yii\db\Migration;

/**
 * Class m190819_075647_alter_message_table
 */
class m190819_075647_alter_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('message', 'is_read', $this->tinyInteger()->after('subject_from_id')->comment('Прочитано')->defaultValue(0));
        $this->addColumn('message', 'deleted_by_receiver', $this->tinyInteger()->after('is_read')->comment('Удалено получателем')->defaultValue(0));
        $this->addColumn('message', 'deleted_by_sender', $this->tinyInteger()->after('deleted_by_receiver')->comment('Удалено отправителем')->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('message', 'is_read');
        $this->dropColumn('message', 'deleted_by_receiver');
        $this->dropColumn('message', 'deleted_by_sender');
    }
}
