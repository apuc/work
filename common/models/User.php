<?php
namespace common\models;

use yii\web\IdentityInterface;

class User extends \dektrium\user\models\User implements IdentityInterface
{
    public function fields()
    {
        return ['id', 'email'];
    }
}
