<?php
namespace common\models;

use common\models\base\WorkActiveRecord;
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
 *
 * @property User $security
 * @property Vacancy[] $vacancy
 * @property Phone $phone
 */
class Company extends WorkActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

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
            [['user_id', 'name'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['user', 'vacancy', 'phone'];
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
            'updated_at' => 'Изменен'
        ];
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
    public function getPhone()
    {
        return $this->hasOne(Phone::className(), ['company_id' => 'id']);
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
}