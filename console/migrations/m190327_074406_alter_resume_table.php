<?php

use yii\db\Migration;

/**
 * Class m190327_074406_alter_resume_table
 */
class m190327_074406_alter_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('education', 'specialisation', 'specialization');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('education', 'specialization', 'specialisation');
    }

}
