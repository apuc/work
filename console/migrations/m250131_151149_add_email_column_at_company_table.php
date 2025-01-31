<?php

use yii\db\Migration;

/**
 * Class m250131_151149_add_email_column_at_company_table
 */
class m250131_151149_add_email_column_at_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company', 'email', $this->string(255)->null()->after('skype'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company', 'email');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250131_151149_add_email_column_at_company_table cannot be reverted.\n";

        return false;
    }
    */
}
