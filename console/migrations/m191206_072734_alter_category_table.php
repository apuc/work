<?php

use yii\db\Migration;

/**
 * Class m191206_072734_alter_category_table
 */
class m191206_072734_alter_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category', 'meta_title', $this->string());
        $this->addColumn('category', 'meta_description', $this->text());
        $this->addColumn('category', 'header', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('category', 'meta_title');
        $this->dropColumn('category', 'meta_description');
        $this->dropColumn('category', 'header');
    }
}
