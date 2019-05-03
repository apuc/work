<?php

namespace frontend\modules\request\controllers;


use common\models\Company;
use common\models\Education;
use common\models\Employer;
use common\models\Experience;
use common\models\Phone;
use common\models\Resume;
use common\models\ResumeSkill;
use common\models\Skill;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\HttpException;
use yii\web\ServerErrorHttpException;

class CompanyController extends MyActiveController
{
    public $modelClass = 'common\models\Company';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    /**
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     * @throws HttpException
     */
    public function actionCreate(){
        if(Yii::$app->user->isGuest)
            throw new HttpException(400, 'Пользователь не авторизирован');
        $model = new Company();
        $params = Yii::$app->getRequest()->getBodyParams();
        $data = explode(',', $params['image']['dataUrl']);


        $image = base64_decode($data[1]);
        $dir = '__DIR__ ../../../web/media/company';
        if(!file_exists($dir))
            mkdir($dir);
        $dir .= '/'.Yii::$app->user->id.'/';
        $file_name = time();
        $file_type = explode('/', $params['image']['type'])[1];
        if(!file_exists($dir))
            mkdir($dir);
        $file = fopen($dir.$file_name.'.'.$file_type, "wb");
        fwrite($file, $image);
        fclose($file);

        $model->load($params, '');
        $model->image_url = '/media/company/'.Yii::$app->user->id.'/'.$file_name.'.'.$file_type;
        $model->user_id = Yii::$app->user->id;
        if($model->save()){
            if($params['phone']){
                $phone = new Phone();
                $phone->company_id = $model->id;
                $phone->number = $params['phone'];
                $phone->save();
            }
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * @param $id
     * @return Company|null
     * @throws HttpException
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionUpdate($id){
        $model = Company::findOne($id);
        if(!$model) throw new HttpException(400, 'Такой компании не существует');
        $this->checkAccess($this->action->id, $model);
        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');
        if(!isset($params['image']['changeImg'])) {
            $data = explode(',', $params['image']['dataUrl']);


            $image = base64_decode($data[1]);
            $dir = '__DIR__ ../../../web/media/company';
            if (!file_exists($dir))
                mkdir($dir);
            $dir .= '/' . Yii::$app->user->id . '/';
            $file_name = time();
            $file_type = explode('/', $params['image']['type'])[1];
            if (!file_exists($dir))
                mkdir($dir);
            $file = fopen($dir . $file_name . '.' . $file_type, "wb");
            fwrite($file, $image);
            fclose($file);

            $model->image_url = '/media/company/' . Yii::$app->user->id . '/' . $file_name . '.' . $file_type;
        }
        $model->user_id = Yii::$app->user->id;
        if($model->save()){
            Phone::deleteAll(['company_id' => $model->id]);
            if($params['phone']){
                $phone = new Phone();
                $phone->company_id = $model->id;
                $phone->number = $params['phone'];
                $phone->save();
            }
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}
