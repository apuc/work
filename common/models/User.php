<?php
namespace common\models;

use common\classes\Debug;
use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property integer $status
 *
 * @property Employer $employer
 * @property Company $company
 */
class User extends \dektrium\user\models\User implements IdentityInterface
{

    const STATUS_EMPLOYER = 1;
    const STATUS_JOB_SEEKER = 2;

    const JOB_SEEKER = 10;
    const EMPLOYER = 20;
    const EMPLOYER_PRIVAT = 21;
    const EMPLOYER_HR = 22;

    public $loginUrl = '/';


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to scenarios
        $scenarios['create'][]   = 'status';
        $scenarios['update'][]   = 'status';
        $scenarios['register'][] = 'status';
        return $scenarios;
    }

    public function rules()
    {
        $rules = parent::rules();
        // add some rules
        $rules['fieldRequired'] = ['status', 'required'];
        $rules['fieldLength']   = ['status', 'integer'];

        return $rules;
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public function fields()
    {
        return ['id', 'email', 'status'];
    }

    public function extraFields()
    {
        return ['employer', 'unreadMessages', 'unreadUpdates', 'company'];
    }

    public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['user_id'=>'id']);
    }

    public function getCompany()
    {
        if ($this->status == self::EMPLOYER_HR) {
            $userCompany = UserCompany::find()->where(['user_id' => $this->id])->one();
            return Company::find()->where(['id' => $userCompany->company_id]);
        }
        return $this->hasOne(Company::className(), ['user_id'=>'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCompany()
    {
        return $this->hasMany(UserCompany::className(), ['user_id' => 'id']);
    }

    public function getUnreadMessages()
    {
        return Message::find()->where(['receiver_id'=>$this->id, 'deleted_by_receiver'=>0, 'is_read'=>0])->count();
    }

    public function getUnreadUpdates()
    {
        return Update::find()->count() - UpdateUser::find()->where(['user_id'=>Yii::$app->user->id])->count();
    }

    public static function getStatus($id)
    {
        $statuses = [self::STATUS_EMPLOYER => 'Работодатель',
            self::STATUS_JOB_SEEKER => 'Соискатель'];

        return isset($statuses[$id]) ? $statuses[$id] : null;
    }
}
