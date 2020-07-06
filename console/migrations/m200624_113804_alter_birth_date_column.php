<?php

use yii\db\Migration;

/**
 * Class m200624_113804_alter_birth_date_column
 */
class m200624_113804_alter_birth_date_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('resume', ['birth_date'=>null]);
        $this->alterColumn('resume', 'birth_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('resume', 'birth_date', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200624_113804_alter_birth_date_column cannot be reverted.\n";

        return false;
    }
    */
}
