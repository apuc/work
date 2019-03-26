<?php
namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "experience".
 *
 * @property integer $id
 * @property integer $resume_id
 * @property string $name
 * @property string $city
 * @property string $post
 * @property string $responsibility
 * @property string $month_from
 * @property string $month_to
 * @property string $year_from
 * @property string $year_to
 * @property string $department
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Resume $resume
 */
class Experience extends ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'experience';
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
            [['resume_id', 'month_from', 'month_to', 'year_from', 'year_to', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'city', 'post', 'month_from', 'department'], 'string', 'max' => 255],
            [['responsibility'], 'string'],
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
            'post' => 'Должность',
            'responsibility' => 'Обязанности',
            'month_from' => 'Месяц начала',
            'month_to' => 'Месяц окончания',
            'year_from' => 'Год начала',
            'year_to' => 'Год окончания',
            'department' => 'Обязанности',
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