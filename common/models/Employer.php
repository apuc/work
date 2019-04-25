<?php
namespace common\models;

use common\models\base\WorkActiveRecord;
use DateTime;
use Exception;
use phpDocumentor\Reflection\Types\Integer;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "employer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $second_name
 * @property string $patronymic
 * @property string $email
 * @property string $birth_date
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $age
 *
 * @property User $security
 * @property Resume[] $resume
 * @property Phone[] $phone
 */
class Employer extends WorkActiveRecord
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

    public function getRelateDeleteList()
    {
        return ['resume', 'phone'];
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
            [['user_id', 'status', 'created_at', 'updated_at', 'owner'], 'integer'],
            [['first_name', 'second_name', 'patronymic', 'email', 'birth_date'], 'string', 'max' => 255],
            [['user_id', 'first_name', 'second_name'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['resume', 'user', 'phone'];
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
            'email' => 'Email',
            'birth_date' => 'Дата рождения',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getResume()
    {
        return $this->hasMany(Resume::className(), ['employer_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPhone()
    {
        return $this->hasMany(Phone::className(), ['employer_id' => 'id']);
    }

    /**
     * @return Integer
     * @throws Exception
     */
    public function getAge()
    {
        return date_diff(new DateTime($this->birth_date), date_create('now'))->y;
    }

}