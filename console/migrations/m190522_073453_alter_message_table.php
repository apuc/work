<?php

use yii\db\Migration;

/**
 * Class m190522_073453_alter_message_table
 */
class m190522_073453_alter_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('message', 'subject_from', $this->string()->comment('Сущность, прикреплённая к сообщению')->after('subject_id'));
        $this->addColumn('message', 'subject_from_id', $this->integer()->comment('Id сущности прикреплённой к сообщению')->after('subject_from'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('message', 'subject_from');
        $this->dropColumn('message', 'subject_from_id');
    }

}
