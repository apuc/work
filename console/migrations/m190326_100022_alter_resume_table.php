<?php

use yii\db\Migration;

/**
 * Class m190326_100022_alter_resume_table
 */
class m190326_100022_alter_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('resume', 'salary');
        $this->addColumn('resume', 'min_salary', $this->decimal(10,2)->comment('Минимальная зарплата')->after('image_url'));
        $this->addColumn('resume', 'max_salary', $this->decimal(10,2)->comment('Максимальная зарплата')->after('min_salary'));
        $this->addColumn('resume', 'vk', $this->string()->comment('Вконтакте')->after('description'));
        $this->addColumn('resume', 'facebook', $this->string()->comment('Facebook')->after('description'));
        $this->addColumn('resume', 'instagram', $this->string()->comment('Instagram')->after('description'));
        $this->addColumn('resume', 'skype', $this->string()->comment('Skype')->after('description'));


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('resume', 'salary', $this->decimal(10,2)->after('image_url'));
        $this->dropColumn('resume', 'min_salary');
        $this->dropColumn('resume', 'max_salary');
        $this->dropColumn('resume', 'vk');
        $this->dropColumn('resume', 'facebook');
        $this->dropColumn('resume', 'instagram');
        $this->dropColumn('resume', 'skype');
    }
}
