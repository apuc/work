<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%news}}`.
 */
class m200514_072528_add_meta_column_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('news', 'country_id', $this->integer());
        $this->addForeignKey('news_country', 'news', 'country_id', 'geobase_country', 'id');
        $this->addColumn('news', 'meta_title', $this->string()->notNull()->comment('Заголовок старницы'));
        $this->addColumn('news', 'meta_description', $this->text()->notNull()->comment('Описание страницы'));
        $this->addColumn('news', 'meta_header', $this->string()->notNull()->comment('h1 заголовок страницы'));
        $this->addColumn('news', 'slug', $this->string()->notNull()->comment('Slug/url страницы'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('news_country', 'news');
        $this->dropColumn('news', 'country_id');
        $this->dropColumn('news', 'meta_title');
        $this->dropColumn('news', 'meta_description');
        $this->dropColumn('news', 'meta_header');
        $this->dropColumn('news', 'slug');

    }
}
