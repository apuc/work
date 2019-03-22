<?php
namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "education".
 *
 * @property integer $id
 * @property integer $resume_id
 * @property string $name
 * @property string $city
 * @property string $faculty
 * @property string $period
 * @property string $description
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Resume $resume
 */
class Education extends ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'education';
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
            [['resume_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'period', 'city', 'faculty'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['resume_id', 'name'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['resume'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resume_id' => 'Резюме',
            'name' => 'Название',
            'city' => 'Город',
            'faculty' => 'Факультет',
            'period' => 'Период',
            'description' => 'Описание',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResume()
    {
        return $this->hasOne(Resume::className(), ['id' => 'resume_id']);
    }
}