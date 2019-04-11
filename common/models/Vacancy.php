<?php
namespace common\models;

use common\models\base\WorkActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vacancy".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $post
 * @property string $responsibilities
 * @property integer $min_salary
 * @property integer $max_salary
 * @property string $qualification_requirements
 * @property string $work_experience
 * @property string $education
 * @property string $working_conditions
 * @property string $video
 * @property string $city
 * @property string $address
 * @property string $home_number
 * @property integer $employment_type_id
 * @property integer $schedule_id
 * @property integer $views
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Company $company
 * @property EmploymentType $employment_type
 * @property Schedule $schedule
 * @property VacancySkill[] $vacancy_skill
 * @property Skill[] $skill
 * @property Category[] $category
 * @property VacancyCategory[] $vacancy_category
 */
class Vacancy extends WorkActiveRecord
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

    public function getRelateDeleteList()
    {
        return ['vacancy_skill', 'vacancy_category'];
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
            [['company_id', 'min_salary', 'max_salary', 'employment_type_id', 'schedule_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['post', 'work_experience', 'education', 'video', 'address', 'home_number', 'city'], 'string', 'max' => 255],
            [['responsibilities', 'qualification_requirements', 'working_conditions'], 'string'],
            [['company_id', 'post'], 'required'],
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
            'post' => 'Должность',
            'responsibilities' => 'Обязанности',
            'min_salary' => 'Минимальная зарплата',
            'max_salary' => 'Максимальная зарплата',
            'qualification_requirements' => 'Требования к квалификации',
            'work_experience' => 'Опыт работы',
            'education' => 'Образование',
            'working_conditions' => 'Условия работы',
            'video' => 'Видео о вакансии',
            'city' => 'Город',
            'address' => 'Адрес офиса',
            'home_number' => 'Номер дома',
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

    /**
     * @inheritdoc
     */
    public function getVacancy_category()
    {
        return $this->hasMany(VacancyCategory::className(), ['vacancy_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getCategory()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('vacancy_category', ['vacancy_id' => 'id']);
    }

}