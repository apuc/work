<?php

use yii\db\Migration;

/**
 * Class m191115_084553_generate_slugs
 */
class m191115_084553_generate_slugs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach (\common\models\City::find()->each(100) as $city){
            /** @var \common\models\City $city */
            $city->slug = \common\classes\LocoTranslitFilter::cyrillicToLatin($city->name, 100, true);
            $city->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
