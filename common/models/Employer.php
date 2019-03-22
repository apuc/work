<?php
namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "employer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $second_name
 * @property string $patronymic
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $security
 * @property Resume[] $resume
 */
class Employer extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employer';
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
            [['first_name', 'second_name', 'patronymic'], 'string', 'max' => 255],
            [['user_id', 'first_name', 'second_name', 'patronymic'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['resume', 'user'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
            'patronymic' => 'Отчество',
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
    public function getResume()
    {
        return $this->hasMany(Resume::className(), ['employer_id' => 'id']);
    }
}