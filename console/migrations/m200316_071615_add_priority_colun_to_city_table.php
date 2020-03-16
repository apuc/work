<?php

use yii\db\Migration;

/**
 * Class m200316_071615_add_priority_colun_to_city_table
 */
class m200316_071615_add_priority_colun_to_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('geobase_city', 'priority', $this->integer()->comment('Приоритет сортировки')->defaultValue(2147483647)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('geobase_city', 'priority');
    }
}
