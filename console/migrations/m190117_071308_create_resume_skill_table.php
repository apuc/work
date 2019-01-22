<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resume_skill`.
 */
class m190117_071308_create_resume_skill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('resume_skill', [
            'id' => $this->primaryKey(),
            'resume_id' => $this->integer(11),
            'skill_id' => $this->integer(11)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('resume_skill');
    }
}
