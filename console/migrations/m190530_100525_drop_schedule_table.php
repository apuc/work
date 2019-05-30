<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%schedule}}`.
 */
class m190530_100525_drop_schedule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('vacancy_schedule', 'vacancy');
        $this->dropTable('schedule');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('schedule', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)
        ]);
    }
}
