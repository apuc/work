<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%vacancy}}`.
 */
class m200416_133047_drop_city_column_from_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('vacancy', 'city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('vacancy', 'city', $this->string());
    }
}
