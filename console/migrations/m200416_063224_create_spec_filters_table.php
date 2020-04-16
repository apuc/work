<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%spec_filters}}`.
 */
class m200416_063224_create_spec_filters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%spec_filters}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255),
            'field_name' => $this->string(255),
            'name' => $this->string(255),
            'sign' => $this->string(15),
            'value' => $this->string(255),
            'dynamic' => $this->tinyInteger()->defaultValue(0),
            'status' => $this->tinyInteger()->defaultValue(1),
            'icon' => $this->text()->null(),
            'color' => $this->text()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%spec_filters}}');
    }
}
