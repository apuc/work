<?php

namespace frontend\modules\request\controllers;


use common\classes\Debug;
use common\classes\FileHandler;
use common\models\Company;
use common\models\Education;
use common\models\Employer;
use common\models\Experience;
use common\models\Phone;
use common\models\Resume;
use common\models\ResumeSkill;
use common\models\Skill;
use common\models\UserCompany;
use common\models\Vacancy;
use common\models\VacancyCategory;
use common\models\VacancySkill;
use dektrium\user\events\FormEvent;
use dektrium\user\models\RegistrationForm;
use dektrium\user\models\Token;
use dektrium\user\models\User;
use frontend\controllers\RegistrationController;
use frontend\models\user\RegUserForm;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\base\UserException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
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

    public function actionMyIndex()
    {
        if(Yii::$app->user->isGuest)
            throw new UserException('Пользователь не авторизирован', 201);
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        $query = $this->modelClass::find()->joinWith('userCompany')->where(['or', ['=', 'owner', Yii::$app->user->id], ['=', 'user_company.user_id', Yii::$app->user->id]])->andWhere(['status'=>1]);
        $model = $query->one();
        if(!$model)
            throw new UserException('У вас нет активной компании', 201);


        $expands = explode(',', Yii::$app->request->get('expand'));
        $response=ArrayHelper::toArray($model);
        if(Yii::$app->request->get('expand')) {
            foreach ($expands as $expand) {
                $exploded = explode('.', $expand);
                if (count($exploded) > 1) {
                    $first_item = $exploded[0];
                    $tmp = $model->$first_item;
                    $response[$first_item] = ArrayHelper::toArray($tmp);
                    foreach ($exploded as $j => $item) {
                        if ($j != 0) {
                            $tmp = $tmp->$item;
                            $response[$first_item][$item] = is_object($tmp) ? ArrayHelper::toArray($tmp) : $tmp;
                        }
                    }

                } else {
                    $response[$expand] = $model->$expand;
                }
            }
        }
        return $response;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if($action === 'update' || $action === 'delete'){
            if(Yii::$app->user->isGuest)
                throw new HttpException(403, 'Вы не авторизированы');
            if(!$model->canAccess(Yii::$app->user->id))
                throw new HttpException(403, 'У вас нет прав для редактирования этой записи');
        }
    }

    public function actionAddUser(){
        $user=User::find()->where(['email'=>Yii::$app->request->post('email')])->one();
        if(!$user)
            throw new HttpException(403, 'Такого пользователя не существует');
        $company=Company::find()->where(['id'=>Yii::$app->request->post('company_id')])->one();
        if(!$company)
            throw new HttpException(403, 'Такой компании не существует');
        if($company->owner!=Yii::$app->user->id)
            throw new HttpException(403, 'У вас нет прав для совершения этого действия');
        if(UserCompany::find()->where(['user_id'=>$user->id, 'company_id'=>$company->id])->one())
            throw new HttpException(403, 'Этот пользователь уже добавлен в вашу компанию');
        $user_company=new UserCompany();
        $user_company->user_id=$user->id;
        $user_company->company_id=$company->id;
        $user_company->save();
        return true;
    }

    public function actionDeleteUser(){
        $company=Company::find()->where(['id'=>Yii::$app->request->post('company_id')])->one();
        if(!$company)
            throw new HttpException(403, 'Такой компании не существует');
        if($company->owner!=Yii::$app->user->id)
            throw new HttpException(403, 'У вас нет прав для совершения этого действия');
        $user_company=UserCompany::find()->where(['company_id'=>$company->id, 'user_id'=>Yii::$app->request->post('user_id')])->one();
        if(!$user_company)
            throw new HttpException(403, 'Этот пользователь не включен в вашу компанию');
        $user_company->delete();
        $employer = Employer::find()->where(['user_id' => Yii::$app->request->post('user_id')])->one();
        if ($employer)
            $employer->delete();
        $user = User::find()->where(['id' => Yii::$app->request->post('user_id')])->one();
        if ($user)
            $user->delete();
        return true;
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
        $model->load($params, '');
        if($params['image']) {
            $model->image_url = FileHandler::saveFileFromBase64($params['image'], 'company');
        }
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
        if($params['image']){
            //unlink(Yii::getAlias("@app").DIRECTORY_SEPARATOR."web$model->image_url");
            $model->image_url = FileHandler::saveFileFromBase64($params['image'], 'company');
        } else {
            if($model->image_url) {
                unlink(Yii::getAlias("@app").DIRECTORY_SEPARATOR."web$model->image_url");
            }
            $model->image_url = null;
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

    public function actionTransfer(){
        $email = Yii::$app->request->post('email');
        $company_id = Yii::$app->request->post('company_id');
        if(!$email)
            throw new UserException('Введите email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new UserException('Неверный email');
        if(!$company_id)
            throw new UserException('Выберите компанию');
        /** @var Company $company */
        $company = Company::find()->where(['id'=>$company_id, 'status'=>Company::STATUS_ACTIVE])->one();
        if(!$company)
            throw new UserException('Такой компании не существует');
        /** @var User $user */
        $user = \common\models\User::find()->where(['email'=>$email])->one();
        $vacancy_ids = Vacancy::find()->where(['company_id'=>$company->id])->column();
        if($user) {
            if((int)Company::find()->where(['owner'=>$user->id, 'status'=>Company::STATUS_ACTIVE])->count()>0) {
                throw new UserException('У этого пользователя уже есть компания');
            }
            if($user->status < 20)
                throw new UserException('Этот пользователь является соискателем');
            $company->owner = $user->id;
            $company->user_id = $user->id;
            $company->save();
            if($vacancy_ids)
                Vacancy::updateAll(['owner' => $user->id], ['id' => $vacancy_ids]);
            Phone::updateAll(['owner'=>$user->id], ['company_id'=>$company->id]);
            VacancyCategory::updateAll(['owner'=>$user->id], ['vacancy_id' => $vacancy_ids]);
            VacancySkill::updateAll(['owner'=>$user->id], ['vacancy_id' => $vacancy_ids]);
        } else {
            $regForm = \Yii::createObject(RegUserForm::className());
            $status = ($company->name=="" || $company->name==null)?21:20;
            $data = [
                'email'=>$email,
                'username'=>$email,
                'password'=>'g8f74n',
                'status'=>$status
            ];
            if ( $regForm->load($data, '') && $regForm->register()) {
                /** @var User $user */
                $user = User::find()->where(['email' => $email])->one();
                $employer = new Employer();
                $employer->user_id = $user->id;
                $employer->owner = $user->id;
                $employer->save();
                $token = Token::findOne(['user_id'=>$user->id]);
                Yii::$app->mailer->viewPath='@common/mail';
                Yii::$app->mailer->compose('company_transfer_notification', ['user'=>$user, 'token'=>$token, 'company'=>$company, 'password'=>'g8f74n'])
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo($user->email)
                    ->setSubject('Спасибо за регистрацию')
                    ->send();
            } else return $regForm->errors;
            $vacancy_ids = Vacancy::find()->where(['company_id'=>$company->id])->column();
            $company->owner = $user->id;
            $company->user_id = $user->id;
            $company->save();
            if($vacancy_ids)
                Vacancy::updateAll(['owner' => $user->id], ['id' => $vacancy_ids]);
            Phone::updateAll(['owner'=>$user->id], ['company_id'=>$company->id]);
            VacancyCategory::updateAll(['owner'=>$user->id], ['vacancy_id' => $vacancy_ids]);
            VacancySkill::updateAll(['owner'=>$user->id], ['vacancy_id' => $vacancy_ids]);
        }
        return 'success';
    }

    public function actionRegisterHr()
    {
        $company = Company::find()->where(['id' => Yii::$app->request->post('company_id')])->one();
        if (!$company)
            throw new HttpException(403, 'Такой компании не существует');
        if ($company->owner != Yii::$app->user->id)
            throw new HttpException(403, 'У вас нет прав для совершения этого действия');
        /** @var User $model */
        $model = new User;
        $post = \Yii::$app->request->post();
        $model->username = $post['email'];
        $model->email = $post['email'];
        $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($post['password']);
        $model->status = 22;
        $model->confirmed_at = time();
        if ($model->save()) {
            $employer = new Employer();
            $employer->first_name = $post['first_name'];
            $employer->second_name = $post['second_name'];
            $employer->user_id = $model->id;
            $employer->owner = $model->id;
            $employer->save();
            $uc = new UserCompany();
            $uc->user_id = $model->id;
            $uc->company_id = $post['company_id'];
            if ($uc->save()) {
                return json_encode('Ваш hr-менеджер успешно зарегистрирован.');
            } else {
                return json_encode($uc->errors);
            }
        } else {
            if ($model->errors)
                throw new HttpException(403, 'Пользователь с таким e-mail`ом уже существует');
        }
    }

    public function actionAddedUsers()
    {
        $company = Company::find()->where(['id' => Yii::$app->request->post('company_id')])->one();
        if (!$company)
            throw new HttpException(403, 'Такой компании не существует');
        if ($company->owner != Yii::$app->user->id)
            throw new HttpException(403, 'У вас нет прав для совершения этого действия');
        return $company->users;
    }
}
