<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "vacancy_skill".
 *
 * @property integer $id
 * @property integer $vacancy_id
 * @property integer $skill_id
 *
 * @property Skill $skill
 * @property Vacancy $vacancy
 */
class VacancySkill extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vacancy_id', 'skill_id'], 'integer'],
            [['vacancy_id', 'skill_id'], 'required'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancy()
    {
        return $this->hasOne(Vacancy::className(), ['id' => 'vacancy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(Skill::className(), ['id' => 'skill_id']);
    }
}