<?php

use yii\db\Migration;

/**
 * Class m191114_113006_generate_slugs
 */
class m191114_113006_generate_slugs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach (\common\models\Category::find()->each(100) as $category){
            /** @var \common\models\Category $category */
            $category->slug = \common\classes\LocoTranslitFilter::cyrillicToLatin($category->name, 100, true);
            $category->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
