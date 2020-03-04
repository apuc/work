<?php

use yii\db\Migration;

/**
 * Class m200304_125033_add_key_value
 */
class m200304_125033_add_key_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('key_value',
                ['key', 'value', 'label'], [
                ['employer_page_title', 'Работодателям - Поиск сотрудников на сайте rabota.today', 'Заголовок страницы для работодателей'],
                ['employer_page_description', 'Информация для работодателей, сайт поиска работы №1. Размещение вакансии, наши партнеры!', 'Описание страницы для работодателей'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('key_value', ['key'=>'employer_page_title']);
        $this->delete('key_value', ['key'=>'employer_page_description']);
    }
}
