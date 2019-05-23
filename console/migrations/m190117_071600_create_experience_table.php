<?php

use yii\db\Migration;

/**
 * Handles the creation of table `experience`.
 */
class m190117_071600_create_experience_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('experience', [
            'id' => $this->primaryKey(),
            'resume_id' => $this->integer(11),
            'name' => $this->string(255),
            'period' => $this->string(255),
            'post' => $this->string(255),
            'responsibility' => $this->string(255),
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
        $this->dropTable('experience');
    }
}
