<?php

namespace backend\modules\company\controllers;

use common\classes\Debug;
use common\classes\tariff\TariffFactory;
use common\models\Phone;
use common\models\User;
use common\models\UserCompany;
use dektrium\user\filters\AccessRule;
use Yii;
use common\models\Company;
use backend\modules\company\models\CompanySearch;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect('/');
                },
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['switch'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            if (isset($post['Company']['users'])) {
                foreach ($post['Company']['users'] as $usr){
                    $userCompany = new UserCompany();
                    $userCompany->company_id = $model->id;
                    $userCompany->user_id = $usr;
                    $userCompany->save();
                }
            }
            $phone = new Phone();
            $phone->company_id = $model->id;
            $phone->number = Yii::$app->request->post('phone_number');
            $phone->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            if ($post['Company']['users']) {
                foreach ($model->userCompany as $usr){
                    $usr->delete();
                }
                foreach ($post['Company']['users'] as $usr){
                    $userCompany = new UserCompany();
                    $userCompany->company_id = $model->id;
                    $userCompany->user_id = $usr;
                    $userCompany->save();
                }
            } else{
                foreach ($model->userCompany as $usr){
                    $usr->delete();
                }
            }
            if($model->phone) {
                $model->phone->number = Yii::$app->request->post('phone_number');
                $model->phone->save();
            } else if(Yii::$app->request->post('phone_number')) {
                $phone = new Phone();
                $phone->company_id = $model->id;
                $phone->number = Yii::$app->request->post('phone_number');
                $phone->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionServices(int $id)
    {
        $model = $this->findModel($id);

        return $this->render('services', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionActivateTariff()
    {
        if (!$company = Company::findOne(Yii::$app->request->post('company_id'))) {
            throw new BadRequestHttpException("Такой компании не существует");
        }
        $tariffFactory = new TariffFactory();
        $tariff = $tariffFactory->getTariffByName(Yii::$app->request->post('tariff'), $company);
        $tariff->activate();
        return $this->redirect(['services', 'id' => $company->id]);
    }
}
