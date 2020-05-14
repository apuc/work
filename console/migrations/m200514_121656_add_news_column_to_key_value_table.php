<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%key_value}}`.
 */
class m200514_121656_add_news_column_to_key_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('key_value', ['key', 'value', 'label'], [
            ['news_meta_title', 'Новости: главная', 'Заголовок новостной страницы'],
            ['news_meta_description', 'Новости: описание', 'Описание новостной страницы'],
            ['news_meta_header', 'Новости: h1 заголовок', 'h1 заголовок новостной страницы'],
            ['news_about', 'Новости: описание', 'Описание страницы новостей']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('key_value', ['key' => 'news_meta_title']);
        $this->delete('key_value', ['key' => 'news_meta_description']);
        $this->delete('key_value', ['key' => 'news_meta_header']);
        $this->delete('key_value', ['key' => 'news_about']);
    }
}
