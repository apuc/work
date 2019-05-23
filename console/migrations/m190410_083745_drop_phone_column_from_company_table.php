<?php

use yii\db\Migration;

/**
 * Handles dropping phone from table `company`.
 */
class m190410_083745_drop_phone_column_from_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('company', 'phone');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('company', 'phone', $this->string()->after('contact_person')->comment('Телефон'));
    }
}
