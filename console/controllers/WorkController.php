<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Exception;

class WorkController extends Controller
{
    public function actionIncrementVacancyRenewCounters() {
        try {
            $connection = Yii::$app->getDb();
            $updated_quantity = $connection->createCommand("
                UPDATE
                    `company`
                SET 
                    `vacancy_renew_count`= `company`.`vacancy_renew_count`+1
                WHERE
                    `vacancy_renew_count` < 5
            ")->execute();
            echo "Successfully updated $updated_quantity companies.\n";
        } catch (Exception $e) {
            echo $e->getMessage()."\n";
        }

    }
}