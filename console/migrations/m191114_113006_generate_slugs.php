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
        $categories = new \yii\db\Query();
        $categories = $categories->from('category')->all();
        foreach ($categories as $category){
            $this->update('category', ['slug'=>\common\classes\LocoTranslitFilter::cyrillicToLatin($category['name'], 100, true)], ['id'=>$category['id']]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
