<?php

use yii\db\Migration;

/**
 * Class m190504_060551_alter_views_column
 */
class m190504_060551_alter_views_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('vacancy', 'views', $this->integer()->after('schedule_id')->comment('Просмотры')->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('vacancy', 'views', $this->integer()->after('schedule_id')->comment('Просмотры'));
    }
}
