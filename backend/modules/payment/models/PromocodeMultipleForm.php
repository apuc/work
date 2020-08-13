<?php

namespace backend\modules\payment\models;

use common\models\Promocode;

class PromocodeMultipleForm extends Promocode
{
    public function rules()
    {
        return [
            [['active_until'], 'date', 'format' => 'php:d-m-Y'],
            [['code'], 'required'],
            [['code'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Промокоды',
            'active_until' => 'Активны до'
        ];
    }
}