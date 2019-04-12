<?php

use yii\db\Migration;

/**
 * Handles adding city to table `vacancy`.
 */
class m190405_093318_add_city_column_to_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'city', $this->string()->comment('Город')->after('video'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy', 'city');
    }
}
