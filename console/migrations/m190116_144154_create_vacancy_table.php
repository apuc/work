<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vacancy`.
 */
class m190116_144154_create_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vacancy', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(11),
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
        $this->dropTable('vacancy');
    }
}
