<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%category}}`.
 */
class m191113_112236_add_image_column_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category', 'image', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('category', 'image');
    }
}
