<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "skill".
 *
 * @property integer $id
 * @property string $name
 */
class Skill extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skill';
    }

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
        return ['resume', 'vacancy', 'resume_skill', 'vacancy_skill'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getVacancy_skill()
    {
        return $this->hasMany(VacancySkill::className(), ['skill_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getResume_skill()
    {
        return $this->hasMany(ResumeSkill::className(), ['resume_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getResume()
    {
        return $this->hasMany(Resume::className(), ['id' => 'resume_id'])
            ->viaTable('resume_skill', ['skill_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getVacancy()
    {
        return $this->hasMany(Vacancy::className(), ['id' => 'vacancy_id'])
            ->viaTable('vacancy_skill', ['skill_id' => 'id']);
    }
}