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
 * @property string $faculty
 * @property integer $year_from
 * @property integer $year_to
 * @property string $academic_degree
 * @property string $specialization
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
            [['resume_id', 'year_from', 'year_to', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'faculty', 'academic_degree', 'specialization'], 'string', 'max' => 255],
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
            'faculty' => 'Факультет',
            'year_from' => 'Год начала',
            'year_to' => 'Год окончания',
            'academic_degree' => 'Академическая степень',
            'specialization' => 'Спецаильность',
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