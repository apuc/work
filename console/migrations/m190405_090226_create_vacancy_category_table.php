<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vacancy_category`.
 */
class m190405_090226_create_vacancy_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vacancy_category', [
            'id' => $this->primaryKey(),
            'vacancy_id' => $this->integer(),
            'category_id' => $this->integer()
        ]);
        $this->addForeignKey('vacancy_vacancy_category', 'vacancy_category', 'vacancy_id', 'vacancy', 'id');
        $this->addForeignKey('category_vacancy_category', 'vacancy_category', 'category_id', 'category', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('vacancy_vacancy_category', 'vacancy_category');
        $this->dropForeignKey('category_vacancy_category', 'vacancy_category');
        $this->dropTable('vacancy_category');
    }
}
