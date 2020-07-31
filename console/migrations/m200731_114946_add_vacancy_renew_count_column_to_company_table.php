<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%company}}`.
 */
class m200731_114946_add_vacancy_renew_count_column_to_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company', 'vacancy_renew_count', $this->tinyInteger()->notNull()->unsigned()->defaultValue(5)->comment('Оставшееся количество подъёмов'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company', 'vacancy_renew_count');
    }
}
