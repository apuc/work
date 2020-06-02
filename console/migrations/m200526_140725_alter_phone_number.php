<?php

use yii\db\Migration;

/**
 * Class m200526_140725_alter_phone_number
 */
class m200526_140725_alter_phone_number extends Migration
{

    public function str_replace_first($from, $to, $content)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $content, 1);
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /** @var \common\models\Phone $phone */
        foreach (\common\models\Phone::find()->each() as $phone) {
            if(strpos($phone->number, '38071') === 0)
                $phone->number = $this->str_replace_first('38071', '+38071', $phone->number);
            if(strpos($phone->number, '8071') === 0)
                $phone->number = $this->str_replace_first('8071', '+38071', $phone->number);
            if(strpos($phone->number, '071') === 0)
                $phone->number = $this->str_replace_first('071', '+38071', $phone->number);

            if(strpos($phone->number, '38063') === 0)
                $phone->number = $this->str_replace_first('38063', '+38063', $phone->number);
            if(strpos($phone->number, '8063') === 0)
                $phone->number = $this->str_replace_first('8063', '+38063', $phone->number);
            if(strpos($phone->number, '063') === 0)
                $phone->number = $this->str_replace_first('063', '+38063', $phone->number);

            if(strpos($phone->number, '38095') === 0)
                $phone->number = $this->str_replace_first('38095', '+38095', $phone->number);
            if(strpos($phone->number, '8095') === 0)
                $phone->number = $this->str_replace_first('8095', '+38095', $phone->number);
            if(strpos($phone->number, '095') === 0)
                $phone->number = $this->str_replace_first('095', '+38095', $phone->number);

            if(strpos($phone->number, '38050') === 0)
                $phone->number = $this->str_replace_first('38050', '+38050', $phone->number);
            if(strpos($phone->number, '8050') === 0)
                $phone->number = $this->str_replace_first('8050', '+38050', $phone->number);
            if(strpos($phone->number, '050') === 0)
                $phone->number = $this->str_replace_first('050', '+38050', $phone->number);

            if(strpos($phone->number, '38066') === 0)
                $phone->number = $this->str_replace_first('38066', '+38066', $phone->number);
            if(strpos($phone->number, '8066') === 0)
                $phone->number = $this->str_replace_first('8066', '+38066', $phone->number);
            if(strpos($phone->number, '066') === 0)
                $phone->number = $this->str_replace_first('066', '+38066', $phone->number);

            if(strpos($phone->number, '38099') === 0)
                $phone->number = $this->str_replace_first('38099', '+38099', $phone->number);
            if(strpos($phone->number, '8099') === 0)
                $phone->number = $this->str_replace_first('8099', '+38099', $phone->number);
            if(strpos($phone->number, '099') === 0)
                $phone->number = $this->str_replace_first('099', '+38099', $phone->number);

            $phone->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
