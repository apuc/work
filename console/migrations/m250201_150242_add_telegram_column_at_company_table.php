<?php

use yii\db\Migration;

/**
 * Class m250201_150242_add_telegram_column_at_company_table
 */
class m250201_150242_add_telegram_column_at_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company', 'telegram', $this->string(255)->null()->after('skype'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company', 'telegram');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250201_150242_add_telegram_column_at_company_table cannot be reverted.\n";

        return false;
    }
    */
}
