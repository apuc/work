<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vacancy_skill`.
 */
class m190117_071417_create_vacancy_skill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vacancy_skill', [
            'id' => $this->primaryKey(),
            'vacancy_id' => $this->integer(11),
            'skill_id' => $this->integer(11)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vacancy_skill');
    }
}
