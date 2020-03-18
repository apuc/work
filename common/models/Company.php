<?php
namespace common\models;

use common\models\base\WorkActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $image_url
 * @property string $name
 * @property string $website
 * @property string $activity_field
 * @property string $vk
 * @property string $facebook
 * @property string $instagram
 * @property string $skype
 * @property string $description
 * @property string $contact_person
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $owner
 * @property integer $countViews
 * @property bool $is_trusted
 *
 * @property User $user
 * @property Vacancy[] $vacancy
 * @property Vacancy[] $activeVacancies
 * @property Phone $phone
 * @property int $clickPhoneCount
 */
class Company extends WorkActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const SOFT_DELETE = 1;

    public function getRelateDeleteList()
    {
        return ['vacancy', 'phone'];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'website', 'vk', 'facebook', 'instagram', 'skype', 'contact_person', 'image_url'], 'string', 'max' => 255],
            [['activity_field', 'description'], 'string'],
            [['is_trusted'], 'boolean'],
            [['user_id', 'contact_person'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['user', 'vacancy', 'phone', 'userCompany', 'users', 'clickPhoneCount'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'name' => 'Название',
            'image_url' => 'Фотография',
            'website' => 'Сайт',
            'activity_field' => 'Сфера деятельности',
            'vk' => 'VK',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'skype' => 'Skype',
            'description' => 'О компании',
            'contact_person' => 'Контактное лицо',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
            'is_trusted' => 'Доверенная'
        ];
    }

    public function getPhotoOrEmptyPhoto(Category $category){
        if($this->image_url)
            return $this->image_url;
        else if($category && $category->icon && $category->name != "Пустая категория")
            return $category->icon;
        else
            return '/images/company_empty.png';
    }

    public function canAccess($user_id){
        $access=false;
        foreach ($this->userCompany as $user_company){
            if($user_company->user_id==Yii::$app->user->id)
                $access=true;
        }
        if($this->owner != Yii::$app->user->id && !$access)
            return false;
        return true;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancy()
    {
        return $this->hasMany(Vacancy::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveVacancies()
    {
        return $this->getVacancy()->andWhere(['status'=>Vacancy::STATUS_ACTIVE]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhone()
    {
        return $this->hasOne(Phone::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCompany()
    {
        return $this->hasMany(UserCompany::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->via('userCompany');
    }

    public function getCountViews()
    {
        return Views::find()->where(['subject_id' => $this->id])->andWhere(['subject_type' => 'Company'])->count();
    }

    /**
     * @return bool
     */
    public function hasSocials()
    {
        if($this->vk) return true;
        if($this->instagram) return true;
        if($this->facebook) return true;
        return false;
    }

    public function getClickPhoneCount() {
        $action = Action::find()
            ->where([
                'type' => 'click_phone',
                'subject' => 'company',
                'subject_id' => $this->id
            ])
            ->one();
        if($action)
            return $action->count;
        else
            return 0;
    }
}