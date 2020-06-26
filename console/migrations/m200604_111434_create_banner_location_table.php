<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banner_location}}`.
 */
class m200604_111434_create_banner_location_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('banner_location', [
            'id' => $this->primaryKey(),
            'banner_id' => $this->integer(11),
            'category_id' => $this->integer(11),
            'city_id' => $this->integer(6)
        ]);

        $this->addFkBannerLocationBanner();
        $this->addFkBannerLocationCategory();
        $this->addFkBannerLocationCity();
    }


    /**
     * Add references to banner_id
     */
    private function addFkBannerLocationBanner()
    {
        $this->addForeignKey(
            'banner_location_banner',
            'banner_location',
            'banner_id',
            'banner',
            'id',
            'CASCADE'
        );
    }


    /**
     * Add references to category_id
     */
    private function addFkBannerLocationCategory()
    {
        $this->addForeignKey(
            'banner_location_category',
            'banner_location',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
    }


    /**
     * Add references to city_id
     */
    private function addFkBannerLocationCity()
    {
        $this->addForeignKey(
            'banner_location_city',
            'banner_location',
            'city_id',
            'geobase_city',
            'id',
            'CASCADE'
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('banner_location');
    }
}
