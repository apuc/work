<?php

use yii\db\Migration;

/**
 * Class m190205_133617_alter_education_table
 */
class m190205_133617_alter_education_table extends Migration
{
    public function up()
    {
        $this->addColumn('education', 'faculty', $this->string()->after('name'));
        $this->addColumn('education', 'city', $this->string()->after('name'));
        $this->alterColumn('education', 'description', $this->text());
    }

    public function down()
    {
        $this->dropColumn('education', 'faculty');
        $this->dropColumn('education', 'city');
        $this->alterColumn('education', 'description', $this->string());
    }
}
