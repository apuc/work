<?php

use yii\db\Migration;

/**
 * Class m200828_113715_fill_service_price_table
 */
class m200828_113715_fill_service_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('service_price', ['name', 'alias', 'price'], [
            ['Поднятие вакансии', 'vacancy_renew', 100],
            ['Активация баннера', 'banner_activate', 250],
            ['Создание вакансии', 'vacancy_create', 200],
            ['Вакансия дня', 'day_vacancy', 150],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

}
