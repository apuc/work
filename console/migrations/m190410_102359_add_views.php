<?php

use yii\db\Migration;

/**
 * Class m190410_102359_add_views
 */
class m190410_102359_add_views extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'views', $this->integer()->comment('Просмотры')-> after('schedule_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacancy', 'views');
    }

}
