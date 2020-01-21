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
 * @property string $birth_date
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $owner
 * @property integer $age
 *
 * @property User $user
 * @property Resume[] $resume
 * @property Phone $phone
 */
class Employer extends WorkActiveRecord
{
    const SOFT_DELETE = 1;

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
            [['first_name', 'second_name', 'birth_date'], 'string', 'max' => 255],
            [['user_id'], 'required'],
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
            'birth_date' => 'Дата рождения',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Изменен',
            'owner' => 'Пользователь'
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
        return $this->hasOne(Phone::className(), ['employer_id' => 'id']);
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getAge()
    {
        if($this->birth_date===null) return 0;
        return date_diff(new DateTime($this->birth_date), date_create('now'))->y;
    }
}