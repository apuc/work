<?php

use common\models\Category;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%category}}`.
 */
class m200313_123434_add_icon_column_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category', 'icon', $this->string());
        /** @var Category $category */
        foreach (\common\models\Category::find()->all() as $category) {
            $category->icon = "/images/categories/$category->slug.svg";
            $category->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('category', 'icon');
    }
}
