<?php

use yii\db\Migration;

/**
 * Class m190326_103914_alter_experience_table
 */
class m190326_103914_alter_experience_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('experience', 'period');
        $this->addColumn('experience', 'department', $this->string()->comment('Отдел')->after('responsibility'));
        $this->addColumn('experience', 'year_to', $this->integer()->comment('Год окончания')->after('responsibility'));
        $this->addColumn('experience', 'year_from', $this->integer()->comment('Год начала')->after('responsibility'));
        $this->addColumn('experience', 'month_to', $this->integer()->comment('Месяц окончания')->after('responsibility'));
        $this->addColumn('experience', 'month_from', $this->integer()->comment('Месяц начала')->after('responsibility'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('experience', 'period', $this->string());
        $this->dropColumn('experience', 'department');
        $this->dropColumn('experience', 'year_to');
        $this->dropColumn('experience', 'year_from');
        $this->dropColumn('experience', 'month_to');
        $this->dropColumn('experience', 'month_from');
    }
}
