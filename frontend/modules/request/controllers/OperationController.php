<?php

namespace frontend\modules\request\controllers;


use common\models\FKPayment;
use common\models\Operation;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\HttpException;

class OperationController extends MyActiveController
{
    public $modelClass = 'common\models\Operation';
    public function actionMyIndex(){
        if(Yii::$app->user->isGuest)
            throw new HttpException(201, 'Пользователь не авторизирован');
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        $all = [];
        /** @var Operation[] $operations */
        $operations = Operation::find()->where(['owner'=>Yii::$app->user->id])->joinWith('servicePrice')->orderBy('created_at DESC')->all();
        /** @var FKPayment[] $FKPayments */
        $FKPayments = FKPayment::find()->where(['company_id'=>Yii::$app->user->identity->company->id])->orderBy('date DESC')->all();
        while (count($operations) > 0 || count($FKPayments) > 0) {
            if (!$operations) {
                foreach ($FKPayments as $payment) {
                    $all[] = [
                        'name' => 'Оплата',
                        'date' => $payment->date,
                        'amount' => $payment->amount
                    ];
                }
                break;
            }
            if (!$FKPayments) {
                foreach ($operations as $operation) {
                    $all[] = [
                        'name' => $operation->servicePrice->name,
                        'date' => $operation->created_at,
                        'amount' => $operation->price
                    ];
                }
                break;
            }
            if ($operations[0]->created_at > $FKPayments[0]->date) {
                $all[] = [
                    'name' => $operations[0]->servicePrice->name,
                    'date' => $operations[0]->created_at,
                    'amount' => $operations[0]->price
                ];
                unset($operations[0]);
                sort($operations);
            } else {
                $all[] = [
                    'name' => 'Оплата',
                    'date' => $FKPayments[0]->date,
                    'amount' => $FKPayments[0]->amount
                ];
                unset($FKPayments[0]);
                sort($FKPayments);
            }
        }
        return ['models' => $all];
        $dataProvider = new ArrayDataProvider([
            'allModels' => $all
        ]);
        $pagination = [
            'current_page'=>$dataProvider->getPagination()->getPage()+1,
            'page_count'=>$dataProvider->getPagination()->getPageCount(),
            'per_page'=>$dataProvider->getPagination()->getPageSize(),
            'total_count'=>$dataProvider->getTotalCount(),
        ];

        return ['pagination'=>$pagination, 'models'=>$dataProvider->getModels()];
    }

    public function actions()
    {
        return [];
    }
}
