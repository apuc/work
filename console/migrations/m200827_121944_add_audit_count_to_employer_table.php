<?php

use yii\db\Migration;

/**
 * Class m200827_121944_add_audit_count_to_employer_table
 */
class m200827_121944_add_audit_count_to_employer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('employer', 'audit_count', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('employer', 'audit_count');
    }
}
