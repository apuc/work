<?php

namespace console\controllers;

use backend\modules\mail_delivery\models\MailDelivery;
use common\classes\Debug;
use common\models\City;
use common\models\Message;
use common\models\Resume;
use common\models\SendMail;
use common\models\User;
use common\models\Vacancy;
use Yii;
use yii\console\Controller;
use yii\db\Query;

class CityController extends Controller
{
    public function actionSort() {
        $query = (new Query())->from('vacancy')->select(['city_id'])->groupBy('city_id')->orderBy('count(city_id) DESC');
        $priority = 1;
        foreach ($query->each() as $vacancy) {
            if($city = City::findOne($vacancy['city_id'])) {
                $city->priority = $priority;
                $city->save();
                echo $city->name . ' -------> ' . $priority . "\n";
                $priority++;
            }
        }
    }
}