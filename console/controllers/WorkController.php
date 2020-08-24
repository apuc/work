<?php

namespace console\controllers;

use common\models\Company;
use common\models\Vacancy;
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
                    `vacancy_renew_count` < 3
            ")->execute();
            echo "Successfully updated $updated_quantity companies.\n";
        } catch (Exception $e) {
            echo $e->getMessage()."\n";
        }

    }

    public function actionIncrementVacancyCreateCounters() {
        try {
            $connection = Yii::$app->getDb();
            $updated_quantity = $connection->createCommand("
                UPDATE
                    `company`
                SET 
                    `create_vacancy`= `company`.`create_vacancy`+1
                WHERE
                    `create_vacancy` < 3
            ")->execute();
            echo "Successfully updated $updated_quantity companies.\n";
        } catch (Exception $e) {
            echo $e->getMessage()."\n";
        }

    }

    public function actionUpdateVacancyCreate() {
        /** @var Company $company */
        foreach (Company::find()->each() as $company) {
            $vacancyCount = Vacancy::find()->where(['company_id' => $company->id])->count();
            if ($vacancyCount > 2)
                $company->create_vacancy = 0;
            else
                $company->create_vacancy = 3 - $vacancyCount;
        }
    }
}