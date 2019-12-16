<?php

use yii\db\Migration;

/**
 * Class m191215_115136_alter_category_table
 */
class m191215_115136_alter_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category', 'meta_title_with_city', $this->string()->comment('Meta title для случая, если вместе с категорией выбран город'));
        $this->addColumn('category', 'meta_description_with_city', $this->text()->comment('Meta description для случая, если вместе с категорией выбран город'));
        $this->addColumn('category', 'header_with_city', $this->string()->comment('H1 заголовок для случая, если вместе с категорией выбран город'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('category', 'meta_title_with_city');
        $this->dropColumn('category', 'meta_description_with_city');
        $this->dropColumn('category', 'header_with_city');
    }
}
