<?php

use yii\db\Migration;

/**
 * Handles dropping patronymic from table `{{%employer}}`.
 */
class m190530_111401_drop_patronymic_column_from_employer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('employer','patronymic');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('employer','patronymic', $this->string()->after('second_name'));
    }
}
