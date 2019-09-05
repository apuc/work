<?php

use yii\db\Migration;

/**
 * Handles adding hot to table `{{%vacancy}}`.
 */
class m190816_120945_add_hot_column_to_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'hot', $this->tinyInteger()->after('views')->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy', 'hot');
    }
}
