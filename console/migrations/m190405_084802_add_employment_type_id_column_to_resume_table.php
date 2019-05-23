<?php

use yii\db\Migration;

/**
 * Handles adding employment_type_id to table `resume`.
 */
class m190405_084802_add_employment_type_id_column_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('resume_employment_type');
        $this->addColumn('resume', 'employment_type_id', $this->integer()->after('employer_id')->comment('Вид занятости'));
        $this->addForeignKey('resume_employment_type', 'resume', 'employment_type_id', 'employment_type', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('resume_employment_type', 'resume');
        $this->dropColumn('resume', 'employment_type_id');
    }
}
