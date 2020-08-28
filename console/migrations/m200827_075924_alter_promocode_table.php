<?php

use yii\db\Migration;

/**
 * Class m200827_075924_alter_promocode_table
 */
class m200827_075924_alter_promocode_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('promocode', 'usages_left', $this->integer()->unsigned());
        $this->addColumn('promocode', 'action', $this->string(64));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('promocode', 'usages_left');
        $this->dropColumn('promocode', 'action');
    }
}
