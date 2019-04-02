<?php

use yii\db\Migration;

/**
 * Class m190326_103037_alter_education_table
 */
class m190326_103037_alter_education_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('education', 'period');
        $this->dropColumn('education', 'city');
        $this->dropColumn('education', 'description');
        $this->addColumn('education', 'year_to', $this->integer()->comment('Год окончания')->after('faculty'));
        $this->addColumn('education', 'year_from', $this->integer()->comment('Год начала')->after('faculty'));
        $this->addColumn('education', 'academic_degree', $this->string()->comment('Академическая степень')->after('year_to'));
        $this->addColumn('education', 'specialisation', $this->string()->comment('Специализация')->after('academic_degree'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('education', 'period', $this->string()->after('name'));
        $this->addColumn('education', 'city', $this->string()->after('name'));
        $this->addColumn('education', 'description', $this->text());
        $this->dropColumn('education', 'year_to');
        $this->dropColumn('education', 'year_from');
        $this->dropColumn('education', 'academic_degree');
        $this->dropColumn('education', 'specialisation');
    }
}
