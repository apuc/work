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
        if (!$countries = Yii::$app->cache->get("main_page_countries")) {
            $countries = Country::find()->select(['id', 'name'])->all();
            Yii::$app->cache->set("main_page_countries", $countries, 3600);
        }
        return $this->render('second-header', [
            'employer' => $employer,
            'countries' => $countries
        ]);
    }
}