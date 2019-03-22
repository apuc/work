<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "resume_employment_type".
 *
 * @property int $id
 * @property int $resume_id
 * @property int $employment_type_id
 *
 * @property EmploymentType $employmentType
 * @property Resume $resume
 */
class ResumeEmploymentType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_employment_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resume_id', 'employment_type_id'], 'integer'],
            [['employment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmploymentType::className(), 'targetAttribute' => ['employment_type_id' => 'id']],
            [['resume_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resume::className(), 'targetAttribute' => ['resume_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resume_id' => 'Resume ID',
            'employment_type_id' => 'Employment Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmploymentType()
    {
        return $this->hasOne(EmploymentType::className(), ['id' => 'employment_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResume()
    {
        return $this->hasOne(Resume::className(), ['id' => 'resume_id']);
    }
}
