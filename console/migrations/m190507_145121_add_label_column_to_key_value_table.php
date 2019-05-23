<?php

use yii\db\Migration;

/**
 * Handles adding label to table `key_value`.
 */
class m190507_145121_add_label_column_to_key_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('key_value', 'label', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('key_value', 'label');
    }
}
