<?php

use yii\db\Migration;

/**
 * Handles adding views to table `resume`.
 */
class m190520_132744_add_views_column_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume', 'views', $this->integer()->defaultValue(0)->comment('Просмотры')->after('vk'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume', 'views');
    }
}
