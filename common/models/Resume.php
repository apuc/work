<?php
namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "resume".
 *
 * @property integer $id
 * @property integer $employer_id
 * @property string $title
 * @property string $image_url
 * @property float $min_salary
 * @property float $max_salary
 * @property string $city
 * @property string $description
 * @property string $skype
 * @property string $instagram
 * @property string $facebook
 * @property string $vk
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Employer $employer
 * @property Experience[] $experience
 * @property Education[] $education
 * @property ResumeCategory[] $resume_category
 * @property Category[] $category
 * @property ResumeEmploymentType[] $resume_employment_type
 * @property EmploymentType[] $employment_type
 * @property ResumeSkill[] $resume_skill
 * @property Skill[] $skill
 */
class Resume extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resume';
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
            [['employer_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'city', 'image_url', 'skype', 'instagram', 'facebook', 'vk'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['min_salary', 'max_salary'], 'safe'],
            [['employer_id', 'title'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['employer', 'experience', 'education', 'resume_skill', 'skill', 'resume_category', 'category', 'resume_employment_type', 'employment_type'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employer_id' => 'Сотрудник',
            'title' => 'Заголовок',
            'min_salary' => 'Минимальная заработная плата',
            'max_salary' => 'Максимальная заработная плата',
            'city' => 'Город',
            'description' => 'Описание',
            'skype' => 'Skype',
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'vk' => 'VK',
            'status' => 'Статус',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено'
        ];
    }

    /**
     * @inheritdoc
     */
    public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['id' => 'employer_id']);
    }

    /**
     * @inheritdoc
     */
    public function getExperience()
    {
        return $this->hasMany(Experience::className(), ['resume_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getEducation()
    {
        return $this->hasMany(Education::className(), ['resume_id' => 'id']);
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
    public function getSkill()
    {
        return $this->hasMany(Skill::className(), ['id' => 'skill_id'])
            ->viaTable('resume_skill', ['resume_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getResume_category()
    {
        return $this->hasMany(ResumeCategory::className(), ['resume_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getCategory()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('resume_category', ['resume_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getResume_employment_type()
    {
        return $this->hasMany(ResumeEmploymentType::className(), ['resume_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getEmployment_type()
    {
        return $this->hasMany(EmploymentType::className(), ['id' => 'employment_type_id'])
            ->viaTable('resume_employment_type', ['resume_id' => 'id']);
    }
}