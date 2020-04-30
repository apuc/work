<?php
namespace frontend\widgets;

use common\models\Country;
use common\models\Employer;
use Yii;
use yii\base\Widget;

class SecondHeader extends Widget
{
    public function run(){
        $employer = \Yii::$app->user->isGuest?null:Employer::find()->where(['user_id'=>\Yii::$app->user->id])->one();
        return $this->render('second-header', [
            'employer' => $employer
        ]);
    }
}