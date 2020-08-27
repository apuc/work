<?php


namespace backend\modules\payment\models;


use common\models\Promocode;

class PromocodeForm extends Promocode
{
    public function rules()
    {
        return [
            [['active_until'], 'date', 'format' => 'php:d-m-Y'],
            [['usages_left'], 'integer', 'min'=>0],
            [['code'], 'required'],
            [['code'], 'string', 'max' => 50],
            [['action'], 'string', 'max' => 64],
        ];
    }

    public function beforeSave($insert)
    {
        $this->active_until = strtotime($this->active_until);
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->active_until = date('d-m-Y', $this->active_until);
        return parent::beforeValidate();
    }
}