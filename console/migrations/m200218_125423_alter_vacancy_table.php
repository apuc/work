<?php

use yii\db\Migration;

/**
 * Class m200218_125423_alter_vacancy_table
 */
class m200218_125423_alter_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $empty_category = (new \yii\db\Query())->from('category')->where(['name'=>'Пустая категория'])->one()['id'];
        $this->alterColumn('vacancy', 'main_category_id', $this->integer()->notNull()->defaultValue($empty_category));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
