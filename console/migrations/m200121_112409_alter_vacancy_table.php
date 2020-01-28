<?php

use common\models\Vacancy;
use yii\db\Migration;

/**
 * Class m200121_112409_alter_vacancy_table
 */
class m200121_112409_alter_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacancy', 'city_id', $this->integer(6)->unsigned()->after('city'));
        $this->addForeignKey('vacancy_geobase_city', 'vacancy', 'city_id', 'geobase_city', 'id');
        /** @var Vacancy $vacancy */
        foreach (Vacancy::find()->each() as $vacancy) {
            /** @var \common\models\City $city */
            if($city = \common\models\City::find()->where(['name'=>$vacancy->city])->one()){
                $vacancy->city_id=$city->id;
                $vacancy->save();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('vacancy_geobase_city', 'vacancy');
        $this->dropColumn('vacancy', 'city_id');
    }
}
