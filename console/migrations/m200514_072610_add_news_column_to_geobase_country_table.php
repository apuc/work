<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%geobase_country}}`.
 */
class m200514_072610_add_news_column_to_geobase_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('geobase_country', 'news_meta_title', $this->string()->comment('Заголовок страницы новостей'));
        $this->addColumn('geobase_country', 'news_meta_description', $this->text()->comment('Описание страницы новостей'));
        $this->addColumn('geobase_country', 'news_meta_header', $this->string()->comment('h1 заголовок страницы новостей'));
        $this->addColumn('geobase_country', 'news_about', $this->text()->comment('Немного о сайте новостей'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('geobase_country', 'news_meta_title');
        $this->dropColumn('geobase_country', 'news_meta_description');
        $this->dropColumn('geobase_country', 'news_meta_header');
        $this->dropColumn('geobase_country', 'news_about');
    }
}
