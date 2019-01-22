<?php

use yii\db\Migration;

/**
 * Handles the creation of table `education`.
 */
class m190117_071702_create_education_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('education', [
            'id' => $this->primaryKey(),
            'resume_id' => $this->integer(11),
            'name' => $this->string(255),
            'period' => $this->string(255),
            'description' => $this->string(),
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
        $this->dropTable('education');
    }
}
