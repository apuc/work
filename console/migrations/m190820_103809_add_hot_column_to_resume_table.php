<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%resume}}`.
 */
class m190820_103809_add_hot_column_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume', 'hot', $this->tinyInteger()->after('views'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume', 'hot');
    }
}
