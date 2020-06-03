<?php

use yii\db\Migration;

/**
 * Class m200602_103931_alter_phone_table
 */
class m200602_103931_alter_phone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /** @var \common\models\Phone $phone */
        foreach (\common\models\Phone::find()->each() as $phone) {
            if(strpos($phone->number, '7') === 0) {
                $phone->number = '+'.$phone->number;
                $phone->save();
            }
            if(strpos($phone->number, '8') === 0) {
                $phone->number = '+7'.substr($phone->number, 1);
                $phone->save();
            }
            if(strpos($phone->number, '+380') === 0) {
                $phone->number = substr($phone->number, 0, 4).' '.
                    substr($phone->number, 4, 2).' '.
                    substr($phone->number, 6, 3).' '.
                    substr($phone->number, 9);
                $phone->save();
            }
            if(strpos($phone->number, '+7') === 0) {
                $phone->number = substr($phone->number, 0, 2).' '.
                    substr($phone->number, 2, 3).' '.
                    substr($phone->number, 5, 3).'-'.
                    substr($phone->number, 8, 2).'-'.
                    substr($phone->number, 10);
                $phone->save();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

}
