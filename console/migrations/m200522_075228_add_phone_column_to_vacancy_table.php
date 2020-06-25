<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vacancy}}`.
 */
class m200522_075228_add_phone_column_to_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'phone', $this->string()->comment('Номер телефона'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy', 'phone');
    }
}
