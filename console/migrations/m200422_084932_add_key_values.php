<?php

use yii\db\Migration;

/**
 * Class m200422_084932_add_key_values
 */
class m200422_084932_add_key_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('key_value', ['key', 'value', 'label'], [
            ['cities_page_title', 'Вакансии по городам', 'Заголовок страницы городов'],
            ['cities_page_description', 'Вакансии по городам', 'Описание страницы городов'],
            ['cities_page_h1', 'Вакансии по городам', 'H1 заголовок страницы городов'],
            ['professions_page_title', 'Вакансии по профессиям', 'Заголовок страницы профессий'],
            ['professions_page_description', 'Вакансии по профессиям', 'Описание страницы профессий'],
            ['professions_page_h1', 'Профессии', 'H1 заголовок страницы профессий'],
            ['professions_with_country_page_title', 'Вакансии по профессиям: {country}', 'Заголовок страницы профессий с выбранной страной'],
            ['professions_with_country_page_description', 'Вакансии по профессиям: {country}', 'Описание страницы профессий с выбранной страной'],
            ['professions_with_country_page_h1', 'Профессии: {country}', 'H1 заголовок страницы профессий с выбранной страной'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('key_value', ['key'=>'cities_page_title']);
        $this->delete('key_value', ['key'=>'cities_page_description']);
        $this->delete('key_value', ['key'=>'cities_page_h1']);
        $this->delete('key_value', ['key'=>'professions_page_title']);
        $this->delete('key_value', ['key'=>'professions_page_description']);
        $this->delete('key_value', ['key'=>'professions_page_h1']);
        $this->delete('key_value', ['key'=>'professions_with_country_page_title']);
        $this->delete('key_value', ['key'=>'professions_with_country_page_description']);
        $this->delete('key_value', ['key'=>'professions_with_country_page_h1']);
    }
}
