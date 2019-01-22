<?php

use yii\db\Migration;

/**
 * Handles the creation of table `employment_type`.
 */
class m190117_070803_create_employment_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('employment_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('employment_type');
    }
}
