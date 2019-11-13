<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%city}}`.
 */
class m191113_120928_add_image_column_to_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('geobase_city', 'image', $this->string()->after('prepositional'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('geobase_city', 'image');
    }
}
