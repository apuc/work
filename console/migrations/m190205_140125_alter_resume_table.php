<?php

use yii\db\Migration;

/**
 * Class m190205_140125_alter_resume_table
 */
class m190205_140125_alter_resume_table extends Migration
{
    public function up()
    {
        $this->addColumn('resume', 'city', $this->string()->after('title'));
        $this->addColumn('resume', 'salary', $this->decimal(2)->after('title'));
        $this->addColumn('resume', 'image_url', $this->string()->after('title'));
        $this->dropForeignKey('resume_schedule','resume');
        $this->dropColumn('resume', 'schedule_id');
        $this->dropForeignKey('resume_employment_type','resume');
        $this->dropColumn('resume', 'employment_type_id');
    }

    public function down()
    {
        $this->dropColumn('resume', 'city');
        $this->dropColumn('resume', 'salary');
        $this->dropColumn('resume', 'image_url');
        $this->addColumn('resume', 'schedule_id', $this->integer());
        $this->addForeignKey('resume_schedule', 'resume', 'schedule_id', 'schedule', 'id');
        $this->addColumn('resume', 'employment_type_id', $this->integer());
        $this->addForeignKey('resume_employment_type', 'resume', 'employment_type_id', 'employment_type', 'id');
    }
}
