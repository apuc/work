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
        $empty_category = new \common\models\Category();
        $empty_category->name = 'Пустая категория';
        $empty_category->save();
        $this->alterColumn('vacancy', 'main_category_id', $this->integer()->notNull()->defaultValue($empty_category->id));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
