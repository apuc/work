<?php

use yii\db\Migration;

/**
 * Class m191206_074504_alter_geobase_city_table
 */
class m191206_074504_alter_geobase_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('geobase_city', 'meta_title', $this->string());
        $this->addColumn('geobase_city', 'meta_description', $this->text());
        $this->addColumn('geobase_city', 'header', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('geobase_city', 'meta_title');
        $this->dropColumn('geobase_city', 'meta_description');
        $this->dropColumn('geobase_city', 'header');
    }
}
