<?php

use yii\db\Migration;

/**
 * Class m200421_100741_alter_views_table
 */
class m200421_100741_alter_views_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'views', $this->integer()->defaultValue(0));
        $this->addColumn('views', 'indexed', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy', 'views');
        $this->dropColumn('views', 'indexed');
    }
}
