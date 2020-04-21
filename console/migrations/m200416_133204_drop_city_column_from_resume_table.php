<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%resume}}`.
 */
class m200416_133204_drop_city_column_from_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('resume', 'city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('resume', 'city', $this->string());
    }
}
