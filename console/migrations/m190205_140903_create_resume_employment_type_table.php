<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resume_employment_type`.
 */
class m190205_140903_create_resume_employment_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('resume_employment_type', [
            'id' => $this->primaryKey(),
            'resume_id' => $this->integer(),
            'employment_type_id' => $this->integer()
        ]);
        $this->addForeignKey('resume_resume_employment_type', 'resume_employment_type', 'resume_id', 'resume', 'id');
        $this->addForeignKey('employment_type_resume_employment_type', 'resume_employment_type', 'employment_type_id', 'employment_type', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('resume_resume_employment_type', 'resume_employment_type');
        $this->dropForeignKey('employment_type_resume_employment_type', 'resume_employment_type');
        $this->dropTable('resume_employment_type');
    }
}
