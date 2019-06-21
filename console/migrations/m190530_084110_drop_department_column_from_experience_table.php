<?php

use yii\db\Migration;

/**
 * Handles dropping department from table `{{%experience}}`.
 */
class m190530_084110_drop_department_column_from_experience_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('experience', 'department');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('experience', 'department', $this->string()->after('year_to')->comment('Отдел'));
    }
}
