<?php

namespace frontend\modules\request\controllers;


use common\models\Company;
use common\models\Education;
use common\models\Employer;
use common\models\Experience;
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
     * @return void|\yii\db\ActiveQuery
     */
    public function myQuery(){
        return Company::find()->where(['user_id' => Yii::$app->user->id]);
    }

    /**
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     * @throws HttpException
     */
    public function actionCreate(){
        $model = new Company();
        $params = Yii::$app->getRequest()->getBodyParams();
        $data = explode(',', $params['image']['dataUrl']);


        $image = base64_decode($data[1]);
        $dir = '__DIR__ ../../../web/media/company';
        if(!file_exists($dir))
            mkdir($dir);
        $dir .= Yii::$app->user->id.'/';
        $file_name = time();
        $file_type = explode('/', $params['image']['type'])[1];
        if(!file_exists($dir))
            mkdir($dir);
        $file = fopen($dir.$file_name.'.'.$file_type, "wb");
        fwrite($file, $image);
        fclose($file);
        if(Yii::$app->user->isGuest)
            throw new HttpException(400, 'Пользователь не авторизирован');
        $employer = Employer::findOne(['user_id'=>Yii::$app->user->identity->getId()]);
        if(!$employer)
            throw new HttpException(400, 'Вы не являетесь соискателем');
        $model->load($params, '');
        $model->image_url = '/media/'.Yii::$app->user->id.'/'.$file_name.'.'.$file_type;
        $model->employer_id = $employer->id;
        if($model->save()){
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            if($params['education']){
                foreach($params['education'] as $s_education){
                    $education = new Education();
                    $education->load($s_education, '');
                    $education->resume_id = $model->id;
                    $education->save();
                }
            }
            if($params['work']){
                foreach($params['work'] as $s_experience){
                    $experience = new Experience();
                    $experience->load($s_experience, '');
                    $experience->resume_id = $model->id;
                    $experience->save();
                }
            }
            if($params['skills']){
                ResumeSkill::deleteAll(['resume_id' => $model->id]);
                foreach($params['skills'] as $s_skill){
                    if(!$skill = Skill::find()->where(['name' => $s_skill['name']])->one()){
                        $skill = new Skill();
                        $skill->name = $s_skill['name'];
                        $skill->save();
                    }
                    if(!ResumeSkill::find()->where(['resume_id' => $model->id, 'skill_id' => $skill->id])->one()){
                        $resume_skill = new ResumeSkill();
                        $resume_skill->resume_id = $model->id;
                        $resume_skill->skill_id = $skill->id;
                        $resume_skill->save();
                    }
                }
            }
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}
