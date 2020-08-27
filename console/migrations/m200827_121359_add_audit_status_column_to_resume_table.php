<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%resume}}`.
 */
class m200827_121359_add_audit_status_column_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume', 'audit_status', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume', 'audit_status');
    }
}
