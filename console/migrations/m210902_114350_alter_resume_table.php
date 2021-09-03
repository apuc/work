<?php

use yii\db\Migration;

/**
 * Class m210902_114350_alter_resume_table
 */
class m210902_114350_alter_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume', 'views', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume', 'views');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210902_114350_alter_resume_table cannot be reverted.\n";

        return false;
    }
    */
}
