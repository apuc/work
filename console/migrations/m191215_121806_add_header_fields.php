<?php

use yii\db\Migration;

/**
 * Class m191215_121806_add_header_fields
 */
class m191215_121806_add_header_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('key_value', ['key', 'value', 'label'], [
            ['main_page_h1', 'Работа в ДНР, подбор персонала, резюме, вакансии: Донецк, Горловка, Макеевка → Rabota.today ', 'h1 заголовок главной страницы'],
            ['resume_search_page_h1', 'Резюме в Донецке, Макеевке, Горловке — Rabota.today | Поиск сотрудников, подбор персонала', 'h1 заголовок страницы поиска резюме'],
            ['vacancy_search_page_h1', 'Поиск работы в Донецке, нейдем самые свежие и актуальные вакансии | Твоя работа в Донецке уже на Rabota.today', 'h1 заголовок страницы поиска вакансий']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('category', ['key'=>'main_page_h1']);
        $this->delete('category', ['key'=>'resume_search_page_h1']);
        $this->delete('category', ['key'=>'vacancy_search_page_h1']);
    }
}
