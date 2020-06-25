<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vacancy}}`.
 */
class m200604_083110_add_is_day_vacancy_column_to_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'vacancy',
            'is_day_vacancy',
            $this->tinyInteger(1)
                ->defaultValue(0)
                ->notNull()
                ->comment('Вакансия дня?')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy', 'is_day_vacancy');
    }
}
