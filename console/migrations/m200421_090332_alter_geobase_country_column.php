<?php

use yii\db\Migration;

/**
 * Class m200421_090332_alter_geobase_country_column
 */
class m200421_090332_alter_geobase_country_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('geobase_country', 'search_page_title', $this->string());
        $this->addColumn('geobase_country', 'search_page_header', $this->string());
        $this->addColumn('geobase_country', 'search_page_description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('geobase_country', 'search_page_title');
        $this->dropColumn('geobase_country', 'search_page_header');
        $this->dropColumn('geobase_country', 'search_page_description');
    }
}
