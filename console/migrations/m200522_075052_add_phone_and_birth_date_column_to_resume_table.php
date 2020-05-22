<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%resume}}`.
 */
class m200522_075052_add_phone_and_birth_date_column_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume', 'phone', $this->string()->comment('Номер телефона'));
        $this->addColumn('resume', 'birth_date', $this->integer()->comment('Дата рождения'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume', 'phone');
        $this->dropColumn('resume', 'birth_date');
    }
}
