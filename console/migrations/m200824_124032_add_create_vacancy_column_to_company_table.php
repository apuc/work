<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%company}}`.
 */
class m200824_124032_add_create_vacancy_column_to_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company', 'create_vacancy', $this->integer()->defaultValue(3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company', 'create_vacancy');
    }
}
