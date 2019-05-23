<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "employment_type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Vacancy[] $vacancy
 * @property Resume[] $resume
 */
class EmploymentType extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function extraFields()
    {
        return ['resume', 'vacancy'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancy()
    {
        return $this->hasMany(Vacancy::className(), ['employment_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResume()
    {
        return $this->hasMany(Resume::className(), ['id' => 'resume_id'])
            ->viaTable('resume_employment_type', ['employment_type_id' => 'id']);
    }

}