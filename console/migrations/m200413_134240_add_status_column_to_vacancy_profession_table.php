<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vacancy_profession}}`.
 */
class m200413_134240_add_status_column_to_vacancy_profession_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy_profession', 'status', $this->tinyInteger()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy_profession', 'status');
    }
}
