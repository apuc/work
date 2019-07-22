<?php

use yii\db\Migration;

/**
 * Class m190617_133920_add_subject_id_and_subject_type
 */
class m190617_133920_add_subject_id_and_subject_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('messages','subject_id',$this->integer(11)->defaultValue(null));
        $this->addColumn('messages', 'subject_type', $this->string(55)->defaultValue('none'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('messages','subject_id');
        $this->dropColumn('messages', 'subject_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190617_133920_add_subject_id_and_subject_type cannot be reverted.\n";

        return false;
    }
    */
}
