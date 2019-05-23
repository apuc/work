<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resume`.
 */
class m190116_143712_create_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('resume', [
            'id' => $this->primaryKey(),
            'employer_id' => $this->integer(11),
            'title' => $this->string(),
            'description' => $this->text(),
            'employment_type_id' => $this->integer(11),
            'schedule_id' => $this->integer(11),
            'status' => $this->integer(2)->defaultValue(1),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('resume');
    }
}
