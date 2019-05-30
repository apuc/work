<?php

use yii\db\Migration;

/**
 * Handles dropping city from table `{{%experience}}`.
 */
class m190530_085757_drop_city_column_from_experience_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('experience', 'city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('experience', 'city', $this->string()->after('name'));
    }
}
