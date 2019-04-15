<?php

use yii\db\Migration;

/**
 * Class m190415_112655_alter_vacancy_table
 */
class m190415_112655_alter_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('vacancy', 'work_experience', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('vacancy', 'work_experience', $this->string());
    }
}
