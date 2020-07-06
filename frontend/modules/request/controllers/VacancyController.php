<?php


namespace frontend\modules\request\controllers;

use common\classes\Debug;
use common\models\Category;
use common\models\Company;
use common\models\Vacancy;
use common\models\VacancyCategory;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\ServerErrorHttpException;

class VacancyController extends MyActiveController
{
    public $modelClass = 'common\models\Vacancy';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    public function actionMyIndex()
    {
        if (Yii::$app->user->isGuest) {
            throw new HttpException(201, 'Пользователь не авторизирован');
        }
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        $query = $this->modelClass::find()->joinWith(['company', 'company.userCompany'])
            ->where([
                'or',
                ['=', 'vacancy.owner', Yii::$app->user->id],
                ['=', 'user_company.user_id', Yii::$app->user->id],
                ['=', 'company.owner', Yii::$app->user->id]
            ])
            ->andWhere([Vacancy::tableName().'.status'=>Vacancy::STATUS_ACTIVE]);
        $dataProvider = Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'params' => $requestParams,
                'pageSize' => 10
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);

        $expands = explode(',', Yii::$app->request->get('expand'));
        $models = $dataProvider->getModels();
        $response = [];
        /** @var ActiveRecord[] $models */
        foreach ($models as $i=> $model) {
            $response[$i]=ArrayHelper::toArray($model);
            if(Yii::$app->request->get('expand')) {
                foreach ($expands as $expand) {
                    $exploded = explode('.', $expand);
                    if (count($exploded) > 1) {
                        $first_item = $exploded[0];
                        $tmp = $model->$first_item;
                        $response[$i][$first_item] = ArrayHelper::toArray($tmp);
                        foreach ($exploded as $j => $item) {
                            if ($j != 0) {
                                $tmp = $tmp->$item;
                                $response[$i][$first_item][$item] = is_object($tmp) ? ArrayHelper::toArray($tmp) : $tmp;
                            }
                        }

                    } else {
                        $response[$i][$expand] = $model->$expand;
                    }
                }
            }
        }
        $pagination = [
            'current_page'=>$dataProvider->getPagination()->getPage()+1,
            'page_count'=>$dataProvider->getPagination()->getPageCount(),
            'per_page'=>$dataProvider->getPagination()->getPageSize(),
            'total_count'=>$dataProvider->getTotalCount(),
        ];

        return ['pagination'=>$pagination, 'models'=>$response];
    }

    /**
     * @param string $action
     * @param Vacancy $model
     * @param array $params
     * @throws HttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'update' || $action === 'delete') {
            if (Yii::$app->user->isGuest) {
                throw new HttpException(403, 'Вы не авторизированы');
            }
            if (!$model->company->canAccess(Yii::$app->user->id && $model->owner != Yii::$app->user->id)) {
                throw new HttpException(403, 'У вас нет прав для редактирования этой записи');
            }
        }
    }

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        if ($insert && $this->hasAttribute('owner') && !\Yii::$app->user->isGuest) {
            $this->owner = $this->company->owner;
        }
        return true;
    }

    /**
     * @throws InvalidConfigException
     * @throws HttpException
     */
    public function actionCreate()
    {
        $model = new Vacancy();
        $params = Yii::$app->getRequest()->getBodyParams();
        if (Yii::$app->user->isGuest) {
            throw new HttpException(400, 'Пользователь не авторизирован');
        }
        $model->load($params, '');
        $model->get_update_id = 1;
        $model->update_time = time();
        $model->publisher_id = Yii::$app->user->id;
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        if ($params['category']) {
            foreach ($params['category'] as $category) {
                if (Category::findOne($category)) {
                    $resume_category = new VacancyCategory();
                    $resume_category->vacancy_id = $model->id;
                    $resume_category->category_id = $category;
                    $resume_category->save();
                }
            }
        }
        return $model;
    }

    /**
     * @param $id
     * @return Vacancy|null
     * @throws HttpException
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionUpdate($id)
    {
        $model = Vacancy::findOne($id);
        if (!$model) {
            throw new HttpException(400, 'Такой вакансии не существует');
        }
        $this->checkAccess($this->action->id, $model);
        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');
        $model->get_update_id = 1;
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        VacancyCategory::deleteAll(['vacancy_id' => $model->id]);
        if ($params['category']) {
            foreach ($params['category'] as $category) {
                if (Category::findOne($category)) {
                    $resume_category = new VacancyCategory();
                    $resume_category->vacancy_id = $model->id;
                    $resume_category->category_id = $category;
                    $resume_category->save();
                }
            }
        }
        return $model;
    }

    public function actionUpdateTime()
    {
        $id = Yii::$app->request->post('id');
        $model = Vacancy::findOne($id);
        if (!$model) {
            throw new HttpException(400, 'Такой вакансии не существует');
        }
        if ($model->owner != Yii::$app->user->id) {
            throw new HttpException(400, 'У вас нет прав для совершения этого действия');
        }
        if (!$model->can_update) {
            throw new HttpException(400, 'Достаточно количество времени не прошло');
        }
        $model->update_time = time();
        $model->save();
        $return = Vacancy::find()->asArray()->where(['id' => $id])->one();
        $return['can_update'] = false;
        return $return;
    }

    public function actionGetExperiences()
    {
        $array = [];
        $id = 0;
        foreach (Vacancy::$experiences as $experience) {
            $array[] = [
                'id' => $id,
                'name' => $experience
            ];
            $id++;
        }
        return $array;
    }
}
