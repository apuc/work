<?php

use yii\db\Migration;

/**
 * Class m190801_132312_add_img_column
 */
class m190801_132312_add_img_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('news', 'img', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('news', 'img');
    }
}
