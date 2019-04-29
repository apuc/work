<?php

use yii\db\Migration;

/**
 * Class m190429_114149_add_update_time
 */
class m190429_114149_add_update_time extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume', 'update_time', $this->integer());
        $this->addColumn('vacancy', 'update_time', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume', 'update_time');
        $this->dropColumn('vacancy', 'update_time');
    }

}
