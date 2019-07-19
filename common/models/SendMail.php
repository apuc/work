<?php

namespace common\models;

use yii\db\ActiveRecord;

class SendMail extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%send_queue}}';
    }

    public function rules()
    {
        return [
            [['email', 'template'], 'required'],
            [['email', 'template', 'options'], 'string']
        ];
    }
}