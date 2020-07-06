<?php

namespace backend\modules\banner\controllers;

use backend\modules\banner\Banner;
use common\classes\BannerService;
use common\classes\Debug;
use common\models\BannerLocation;
use common\models\Category;
use common\models\City;
use common\models\Phone;
use dektrium\user\filters\AccessRule;
use Yii;
use common\models\Company;
use backend\modules\company\models\CompanySearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class BannerController extends Controller
{
    /** @var BannerService $bannerService */
    private $bannerService;


    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->bannerService = new BannerService([
            'repository' => \common\models\Banner::className(),
            'locationsRepository' => BannerLocation::className()
        ]);
    }

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
     * Lists all Banner models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => $this->bannerService->getIndexDataProvider()
        ]);
    }

    /**
     * Displays a single Banner model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->bannerService->getById($id)
        ]);
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new $this->bannerService->repository();

        if (Yii::$app->request->isGet) {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        $this->bannerService->switchRepository($model);
        $this->bannerService->updateModelTransaction(Yii::$app->request->post());

        return $this->redirect(['view', 'id' => $model->id]);

    }

    /**
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->bannerService->getById($id);

        if (Yii::$app->request->isGet) {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

        $this->bannerService->switchRepository($model);
        $this->bannerService->updateModelTransaction(Yii::$app->request->post());

        return $this->redirect(['view', 'id' => $model->id]);
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\ErrorException
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->bannerService->deleteById($id);

        return $this->redirect(['index']);
    }

    public function actionPreview(){
        $banner = new \common\models\Banner();
        $banner->load(Yii::$app->request->get(), '');
        return \frontend\widgets\Banner::widget(['banner'=>$banner]);
    }

    /**
     * @param int $index
     * @return string
     */
    public function actionBannerLocationSelect($index)
    {
        $cities = City::find()->select(['id', 'name'])->asArray()->all();
        $categories = Category::find()->select(['id', 'name'])->asArray()->all();

        $cities = ArrayHelper::map($cities, 'id', 'name');
        $categories = ArrayHelper::map($categories, 'id', 'name');

        $model = new $this->bannerService->locationsRepository();
        return $this->renderAjax('bannerLocationSelect', compact('index', 'cities', 'categories', 'model'));
    }
}
