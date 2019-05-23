<?php

use yii\db\Migration;

/**
 * Class m190410_084440_alter_employer_table
 */
class m190410_084440_alter_employer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('employer', 'email', $this->string()->comment('Email')->after('patronymic'));
        $this->addColumn('employer', 'birth_date', $this->date()->comment('Дата рождения')->after('email'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('employer', 'email');
        $this->dropColumn('employer', 'birth_date');
    }
}
