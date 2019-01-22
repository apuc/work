<?php

use yii\db\Migration;

/**
 * Handles the creation of table `employer`.
 */
class m190116_142924_create_employer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('employer', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'first_name' => $this->string(255),
            'second_name' => $this->string(255),
            'patronymic' => $this->string(255),
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
        $this->dropTable('employer');
    }
}
