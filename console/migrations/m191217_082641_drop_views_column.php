<?php

use yii\db\Migration;

/**
 * Class m191217_082641_drop_views_column
 */
class m191217_082641_drop_views_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('resume', 'views');
        $this->dropColumn('vacancy', 'views');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('resume', 'views', $this->integer());
        $this->addColumn('vacancy', 'views', $this->integer());
    }

}
