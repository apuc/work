<?php

use yii\db\Migration;

/**
 * Class m190501_132536_add_years_of_exp_to_resume_table
 */
class m190501_132536_add_years_of_exp_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume', 'years_of_exp', $this->integer()->comment('Количество полных лет опыта')->after('description'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume', 'years_of_exp');
    }
}
