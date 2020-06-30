<?php


namespace frontend\controllers;


use common\classes\Debug;
use common\models\Company;
use common\models\FKPayment;
use common\models\Test;
use yii\web\Controller;

class PaymentController extends Controller
{
    public $merchant_id = 214123;
    public $secret_word = 'm648uqdn';
    public $secret_word2 = 'dz5h59co';

    public $layout = '@frontend/views/layouts/main-layout.php';

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionNotificate() {
        $data = \Yii::$app->request->post();
        $payment = new FKPayment();
        $payment->load([
            'company_id' => $data['MERCHANT_ORDER_ID'],
            'phone' => $data['P_PHONE'],
            'email' => $data['P_EMAIL'],
            'currency_id' => $data['CUR_ID'],
            'amount' => $data['AMOUNT'],
            'operation_number' => $data['intid'],
            'sign' => $data['SIGN']
        ], '');
        if($payment->sign === md5($this->merchant_id.':'.$payment->amount.':'.$this->secret_word2.':'.$payment->company_id)) {
            if($payment->save() && $company = Company::findOne($payment->company_id)) {
                $company->balance += $payment->amount;
                $company->save();
            }
        }
    }
}