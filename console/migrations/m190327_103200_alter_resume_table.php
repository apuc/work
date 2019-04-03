<?php

use yii\db\Migration;

/**
 * Class m190327_103200_alter_resume_table
 */
class m190327_103200_alter_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('resume_employment_type');
        $this->addColumn('resume', 'employment_type_id', $this->integer()->after('title'));
        $this->addForeignKey('resume_employment_type', 'resume', 'employment_type_id', 'employment_type', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
