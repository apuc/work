<?php

use yii\db\Migration;

/**
 * Class m200128_065759_alter_city_category_tables
 */
class m200128_065759_alter_city_category_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('geobase_city', 'bottom_text', $this->text()->comment('Текст, отображающийся внизу страницы поиска вакансий'));
        $this->alterColumn('category', 'bottom_text', $this->text()->comment('Текст, отображающийся внизу страницы поиска вакансий'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('geobase_city', 'bottom_text', $this->string()->comment('Текст, отображающийся внизу страницы поиска вакансий'));
        $this->alterColumn('category', 'bottom_text', $this->string()->comment('Текст, отображающийся внизу страницы поиска вакансий'));
    }
}
