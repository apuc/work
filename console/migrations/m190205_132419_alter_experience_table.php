<?php

use yii\db\Migration;

/**
 * Class m190205_132419_alter_experience_table
 */
class m190205_132419_alter_experience_table extends Migration
{

    public function up()
    {
        $this->alterColumn('experience', 'responsibility', $this->text());
        $this->addColumn('experience', 'city', $this->string()->after('name'));
    }

    public function down()
    {
        $this->alterColumn('experience', 'responsibility', $this->string());
        $this->dropColumn('experience', 'city');
    }
}
