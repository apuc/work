<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vacancy}}`.
 */
class m210120_094404_add_anchored_until_column_to_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'anchored_until', $this->integer()->unsigned()->comment('Закреплена до'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy', 'anchored_until');
    }
}
