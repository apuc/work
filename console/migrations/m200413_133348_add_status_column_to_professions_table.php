<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%professions}}`.
 */
class m200413_133348_add_status_column_to_professions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('professions', 'status', $this->tinyInteger()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('professions', 'status');
    }
}
