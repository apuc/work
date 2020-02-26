<?php

use yii\db\Migration;

/**
 * Class m200226_092833_alter_geobase_city_table
 */
class m200226_092833_alter_geobase_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('geobase_city', 'latitude');
        $this->dropColumn('geobase_city', 'longitude');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
