<?php
namespace common\models;

use common\models\base\WorkActiveRecord;
use Exception;
use phpDocumentor\Reflection\Types\Boolean;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "resume".
 *
 * @property integer $id
 * @property integer $employer_id
 * @property integer $employment_type_id
 * @property string $title
 * @property string $image_url
 * @property float $min_salary
 * @property float $max_salary
 * @property string $city
 * @property string $description
 * @property integer $years_of_exp
 * @property string $skype
 * @property string $instagram
 * @property string $facebook
 * @property string $vk
 * @property integer $views
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $owner
 * @property integer $update_time
 *
 * @property Employer $employer
 * @property EmploymentType $employment_type
 * @property Experience[] $experience
 * @property Education[] $education
 * @property ResumeCategory[] $resume_category
 * @property Category[] $category
 * @property ResumeSkill[] $resume_skill
 * @property Skill[] $skills
 * @property Experience $lastExperience
 * @property bool $can_update
 */
class Resume extends WorkActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const UPDATE_MIN_SEC_PASSED = 86400;

    public function getRelateDeleteList()
    {
        return ['experience', 'education', 'resume_category', 'resume_skill'];
    }

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
            [['employer_id', 'status', 'created_at', 'updated_at', 'employment_type_id', 'owner', 'update_time', 'years_of_exp', 'views'], 'integer'],
            [['title', 'city', 'image_url', 'skype', 'instagram', 'facebook', 'vk'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['min_salary', 'max_salary'], 'safe'],
            [['employer_id', 'title'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['employer', 'experience', 'education', 'resume_skill', 'skills', 'resume_category', 'category', 'employment_type', 'can_update'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employer_id' => 'Сотрудник',
            'employment_type_id' => 'Вид занятости',
            'title' => 'Заголовок',
            'image_url' => 'Картинка',
            'min_salary' => 'Минимальная заработная плата',
            'max_salary' => 'Максимальная заработная плата',
            'city' => 'Город',
            'description' => 'Описание',
            'years_of_exp' => 'Количество полных лет опыта',
            'skype' => 'Skype',
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'vk' => 'VK',
            'views' => 'Просмотры',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
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
    public function getEmployment_type()
    {
        return $this->hasOne(EmploymentType::className(), ['id' => 'employment_type_id']);
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
    public function getSkills()
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
     * @return bool
     */
    public function hasSocials()
    {
        if($this->vk) return true;
        if($this->instagram) return true;
        if($this->facebook) return true;
        return false;
    }

    /**
     * @return bool
     */
    public function getCan_update()
    {
        return (time()-self::UPDATE_MIN_SEC_PASSED) > $this->update_time;
    }

    public function getLastExperience()
    {
        return $this->hasOne(Experience::className(), ['resume_id' => 'id'])->orderBy('year_to DESC, month_to DESC')
            ->where(['>', 'month_from', 0])
            ->andWhere(['<=', 'month_from', 12])
            ->andWhere('year_from IS NOT NULL');
    }

    public static function getFullExperience($experiences){
        if(!empty($experiences)){
            $years = 0;
            $months = 0;
            foreach ($experiences as $experience){
                if(!empty($experience['year_to'])) {
                    $years += $experience['year_to'] - $experience['year_from'];
                    $tmp_months = $experience['month_to'] - $experience['month_from'];
                    if ($tmp_months >= 0) {
                        $months += $tmp_months;
                    } else {
                        $years--;
                        $months += 12 - $experience['month_from'] + $experience['month_to'];
                    }
                }
            }
            return $years + (int)($months/12);
        } else {
          return 0;
        }
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->created_at = date('d-m-Y', $this->created_at);
    }
}