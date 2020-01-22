<?php

use common\models\Resume;
use yii\db\Migration;

/**
 * Class m200121_100218_alter_resume_table
 */
class m200121_100218_alter_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume', 'city_id', $this->integer(6)->unsigned()->after('city'));
        $this->addForeignKey('resume_geobase_city', 'resume', 'city_id', 'geobase_city', 'id');
        /** @var Resume $resume */
        foreach (\common\models\Resume::find()->each() as $resume) {
            /** @var \common\models\City $city */
            if($city = \common\models\City::find()->where(['name'=>$resume->city])->one()){
                $resume->city_id=$city->id;
                $resume->save();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('resume_geobase_city', 'resume');
        $this->dropColumn('resume', 'city_id');
    }
}
