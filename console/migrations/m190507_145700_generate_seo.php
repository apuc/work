<?php

use yii\db\Migration;

/**
 * Class m190507_145700_generate_seo
 */
class m190507_145700_generate_seo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('key_value', ['key', 'value', 'label'], [
            ['main_page_title', 'Работа: главная', 'Заголовок главной страницы'],
            ['main_page_description', 'Описание', 'Описание главной страницы'],
            ['resume_search_page_title', 'Поиск резюме', 'Заголовок страницы поиска резюме'],
            ['resume_search_page_description', 'Описание', 'Описание страницы поиска резюме'],
            ['vacancy_search_page_title', 'Поиск вакансий', 'Заголовок страницы поиска вакансий'],
            ['vacancy_search_page_description', 'Описание', 'Описание страницы поиска вакансий']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('key_value', ['key' => 'main_page_title']);
        $this->delete('key_value', ['key' => 'main_page_description']);
        $this->delete('key_value', ['key' => 'resume_search_page_title']);
        $this->delete('key_value', ['key' => 'resume_search_page_description']);
        $this->delete('key_value', ['key' => 'vacancy_search_page_title']);
        $this->delete('key_value', ['key' => 'vacancy_search_page_description']);
    }
}
