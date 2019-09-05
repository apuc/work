<?php

use yii\db\Migration;

/**
 * Handles adding prepositional to table `{{%geobase_city}}`.
 */
class m190820_084342_add_prepositional_column_to_geobase_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('geobase_city', 'prepositional', $this->string()->after('name'));
        foreach (\common\models\City::find()->each(100) as $city){
            $city->prepositional=morphos\Russian\GeographicalNamesInflection::getCase($city->name, \morphos\Russian\Cases::PREDLOJ);
            $city->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('geobase_city', 'prepositional');
    }
}
