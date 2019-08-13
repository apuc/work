<?php
namespace common\models;

use yii\web\IdentityInterface;

class User extends \dektrium\user\models\User implements IdentityInterface
{
    public function fields()
    {
        return ['id', 'email'];
    }
    public function extraFields()
    {
        return ['employer'];
    }

    public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['user_id'=>'id']);
    }
}
