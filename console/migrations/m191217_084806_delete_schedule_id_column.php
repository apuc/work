<?php

use yii\db\Migration;

/**
 * Class m191217_084806_delete_schedule_id_column
 */
class m191217_084806_delete_schedule_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('vacancy', 'schedule_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('vacancy', 'schedule_id', $this->integer());
    }
}
