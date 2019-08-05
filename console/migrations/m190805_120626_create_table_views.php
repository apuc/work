<?php

use yii\db\Migration;

/**
 * Class m190805_120626_create_table_views
 */
class m190805_120626_create_table_views extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('views',[
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(11),
            'vacancy_id' => $this->integer(11),
            'viewer_id' => $this->integer(11)->defaultValue(null),
            'dt_view' => $this->integer(11)->defaultValue(null),
            'options' => $this->text()->defaultValue(null)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('views');
    }
}
