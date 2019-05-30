<?php

use yii\db\Migration;

/**
 * Handles dropping email from table `{{%employer}}`.
 */
class m190530_081508_drop_email_column_from_employer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('employer', 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('employer', 'email', $this->string()->after('patronymic'));
    }
}
