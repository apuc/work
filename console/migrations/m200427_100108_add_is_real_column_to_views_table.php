<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%views}}`.
 */
class m200427_100108_add_is_real_column_to_views_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('views', 'is_real', $this->boolean()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('views', 'is_real');
    }
}
