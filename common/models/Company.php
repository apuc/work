<?php
namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $website
 * @property string $activity_field
 * @property string $vk
 * @property string $facebook
 * @property string $instagram
 * @property string $skype
 * @property string $description
 * @property string $contact_person
 * @property string $phone
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $security
 * @property Vacancy[] $vacancy
 */
class Company extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

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
            [['name', 'website', 'vk', 'facebook', 'instagram', 'skype', 'contact_person', 'phone'], 'string', 'max' => 255],
            [['activity_field', 'description'], 'string'],
            [['user_id', 'name'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['user', 'vacancy'];
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
            'website' => 'Сайт',
            'activity_field' => 'Сфера деятельности',
            'vk' => 'VK',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'skype' => 'Skype',
            'description' => 'О компании',
            'contact_person' => 'Контактное лицо',
            'phone' => 'Телефон',
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
}