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
        $cities = new \yii\db\Query();
        $cities = $cities->from('geobase_city')->all();
        foreach ($cities as $city){
            $this->update('geobase_city', ['slug'=>\common\classes\LocoTranslitFilter::cyrillicToLatin($city['name'], 100, true)], ['id'=>$city['id']]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
