<?php
namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vacancy".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $title
 * @property string $description
 * @property integer $employment_type_id
 * @property integer $schedule_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Company $company
 * @property EmploymentType $employmentType
 * @property Schedule $schedule
 * @property VacancySkill[] $vacancy_skill
 * @property Skill[] $skill
 */
class Vacancy extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vacancy';
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
            [['company_id', 'employment_type_id', 'schedule_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['company_id', 'title'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['company', 'schedule', 'employment_type', 'vacancy_skill', 'skill'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Работодатель',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'employment_type_id' => 'Вид занятости',
            'schedule_id' => 'Расписание',
            'status' => 'Статус',
            'created_at' => 'Создана',
            'updated_at' => 'Изменена'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
    /**
     * @inheritdoc
     */
    public function getEmployment_type()
    {
        return $this->hasOne(EmploymentType::className(), ['id' => 'employment_type_id']);
    }

    /**
     * @inheritdoc
     */
    public function getSchedule()
    {
        return $this->hasOne(Schedule::className(), ['id' => 'schedule_id']);
    }

    /**
     * @inheritdoc
     */
    public function getVacancy_skill()
    {
        return $this->hasMany(VacancySkill::className(), ['vacancy_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getSkill()
    {
        return $this->hasMany(Skill::className(), ['id' => 'skill_id'])
            ->viaTable('vacancy_skill', ['vacancy_id' => 'id']);
    }
}