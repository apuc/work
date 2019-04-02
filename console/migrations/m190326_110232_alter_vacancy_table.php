<?php

use yii\db\Migration;

/**
 * Class m190326_110232_alter_vacancy_table
 */
class m190326_110232_alter_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'post', $this->string()->comment('Должность')->after('company_id'));
        $this->addColumn('vacancy', 'responsibilities', $this->text()->comment('Обязанности')->after('post'));
        $this->addColumn('vacancy', 'max_salary', $this->integer()->comment('Минимальная зарплата')->after('responsibilities'));
        $this->addColumn('vacancy', 'min_salary', $this->integer()->comment('Максимальная зарплата')->after('responsibilities'));
        $this->addColumn('vacancy', 'qualification_requirements', $this->text()->comment('Требования к квалификации')->after('max_salary'));
        $this->addColumn('vacancy', 'work_experience', $this->string()->comment('Опыт работы')->after('qualification_requirements'));
        $this->addColumn('vacancy', 'education', $this->string()->comment('Образование')->after('work_experience'));
        $this->addColumn('vacancy', 'working_conditions', $this->text()->comment('Условия работы')->after('education'));
        $this->addColumn('vacancy', 'video', $this->string()->comment('Видео о вакансии')->after('working_conditions'));
        $this->addColumn('vacancy', 'address', $this->string()->comment('Адрес офиса')->after('video'));
        $this->addColumn('vacancy', 'home_number', $this->string()->comment('Номер дома')->after('address'));

        $this->dropColumn('vacancy', 'title');
        $this->dropColumn('vacancy', 'description');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('vacancy', 'title', $this->string());
        $this->addColumn('vacancy', 'description', $this->text());

        $this->dropColumn('vacancy', 'post');
        $this->dropColumn('vacancy', 'responsibilities');
        $this->dropColumn('vacancy', 'max_salary');
        $this->dropColumn('vacancy', 'min_salary');
        $this->dropColumn('vacancy', 'qualification_requirements');
        $this->dropColumn('vacancy', 'work_experience');
        $this->dropColumn('vacancy', 'education');
        $this->dropColumn('vacancy', 'working_conditions');
        $this->dropColumn('vacancy', 'video');
        $this->dropColumn('vacancy', 'address');
        $this->dropColumn('vacancy', 'home_number');
    }
}
