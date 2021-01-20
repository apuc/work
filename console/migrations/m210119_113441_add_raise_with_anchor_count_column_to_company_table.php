<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%company}}`.
 */
class m210119_113441_add_raise_with_anchor_count_column_to_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'company',
            'raise_with_anchor_count',
            $this
                ->integer()
                ->unsigned()
                ->comment("Количество осташихся поднятий вакансий с закреплением")
        );
        $this->addColumn(
            'company',
            'raise_with_anchor_until',
            $this
                ->integer()
                ->unsigned()
                ->comment("Время окончания осташихся поднятий вакансий с закреплением")
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(
            'company',
            'raise_with_anchor_count'
        );
        $this->dropColumn(
            'company',
            'raise_with_anchor_until'
        );
    }
}
