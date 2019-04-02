<?php

use yii\db\Migration;

/**
 * Class m190206_104843_alter_resume_table
 */
class m190206_104843_alter_resume_table extends Migration
{

    public function up()
    {
        $this->alterColumn('resume', 'salary', $this->decimal(10, 2));
    }

    public function down()
    {
        $this->alterColumn('resume', 'salary', $this->decimal(2));
    }
}
