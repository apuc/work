<?php
namespace common\models;

use apuc\channels_webhook\behaviors\WebHookBehavior;
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
 * @property integer $city_id
 * @property string $description
 * @property integer $years_of_exp
 * @property string $skype
 * @property string $instagram
 * @property string $facebook
 * @property string $vk
 * @property integer $hot
 * @property integer $notification_status
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
 * @property City $city0
 * @property int $clickPhoneCount
 */
class Resume extends WorkActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 2;

    const NOTIFICATION_STATUS_OK=0;
    const NOTIFICATION_STATUS_1_WEEK=1;
    const NOTIFICATION_STATUS_2_WEEKS=2;

    const UPDATE_MIN_SEC_PASSED = 86400;

    const SOFT_DELETE = 1;

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
            'webHook' => ['class'=>WebHookBehavior::className(),
                'url' => 'https://webhooks.mychannels.gq/rabota/13'
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_id', 'status', 'created_at', 'updated_at', 'employment_type_id', 'owner', 'update_time', 'years_of_exp', 'notification_status', 'hot', 'city_id'], 'integer'],
            [['title', 'city', 'image_url', 'skype', 'instagram', 'facebook', 'vk'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['min_salary', 'max_1salary'], 'safe'],
            [['employer_id', 'title'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['employer', 'experience', 'education', 'resume_skill', 'skills', 'resume_category', 'category', 'employment_type', 'can_update', 'views0', 'countViews', 'city0', 'clickPhoneCount'];
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
            'city_id' => 'Город',
            'description' => 'Описание',
            'years_of_exp' => 'Количество полных лет опыта',
            'skype' => 'Skype',
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'vk' => 'VK',
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

    public function getViews0()
    {
        return $this->hasMany(Views::className(), ['subject_id' => 'id'])->where(['subject_type' => 'Resume']);
    }

    public function getCountViews()
    {
        return Views::find()->where(['subject_id' => $this->id])->andWhere(['subject_type' => 'Resume'])->count();
    }

    /**
     * @param $city City
     * @param $category Category
     * @return array
     */
    public static function getMetaData($city, $category){
        $description = null;
        $header = null;
        $title = null;
        if($city && $category){
            $title=str_replace('{city}', $city->name, $category->metaData->resume_meta_title_with_city);
            $title=str_replace('{region}', $city->region->name, $title);
            $description=str_replace('{city}', $city->name, $category->metaData->resume_meta_description_with_city);
            $description=str_replace('{region}', $city->region->name, $description);
            $header=str_replace('{city}', $city->name, $category->metaData->resume_header_with_city);
            $header=str_replace('{region}', $city->region->name, $header);
        }
        if($city &&(!$title || !$description || !$header)) {
            $title=$title?:$city->resume_meta_title;
            $description=$description?:$city->resume_meta_description;
            $header=$header?:$city->resume_header;
        }
        if($category &&(!$title || !$description || !$header)) {
            $title=$title?:$category->metaData->resume_meta_title;
            $description=$title?:$category->metaData->resume_meta_description;
            $header=$header?:$category->metaData->resume_header;
        }
        $title=$title?:KeyValue::findValueByKey('resume_search_page_title')?:"Поиск Резюме";
        $description=$description?:KeyValue::findValueByKey('resume_search_page_description')?:"Поиск Резюме";
        $header=$header?:KeyValue::findValueByKey('resume_search_page_h1')?:"Поиск Резюме";
        return [
            'title' => $title,
            'description' => $description,
            'header' => $header
        ];
    }

    /**
     * @param bool|string $category_slug
     * @param bool|string $city_slug
     * @return string
     *
     * Получение урл для страницы поиска резюме, с учётом переданных города и категории. Если город не указывать, будет использован город из cookie
     *
     */
    public static function getSearchPageUrl($category_slug = false, $city_slug = false) {
        $url = "/resume";
        if($city_slug) {
            $url .= "/$city_slug";
        }
        else if(\Yii::$app->request->cookies['city'] && $city = City::findOne(\Yii::$app->request->cookies['city'])) {
            $url .= "/$city->slug";
        }
        if($category_slug) {
            $url .= "/$category_slug";
        }
        return $url;
    }

    /**
     * @param int $hoursCount
     * @param int $status
     * @return array|ActiveRecord[]
     *
     * получение новых резюме за определенное кол-во времени
     */
    public static function getNewResume($hoursCount = 24, $status = self::STATUS_ACTIVE)
    {
        return self::find()
            ->where('created_at > UNIX_TIMESTAMP() - ' . $hoursCount . '*60*60')
            ->andWhere(['status' => $status])
            ->all();
    }

    /**
     * @param int $hoursCount
     * @param int $status
     * @return array|ActiveRecord[]
     *
     * получение обновленных резюме за определенное кол-во времени
     */
    public static function getUpdateResume($hoursCount = 24, $status = self::STATUS_ACTIVE)
    {
        return self::find()
            ->where('updated_at > UNIX_TIMESTAMP() - ' . $hoursCount . '*60*60')
            ->andWhere('created_at < UNIX_TIMESTAMP() - ' . $hoursCount . '*60*60')
            ->andWhere(['status' => $status])
            ->all();
    }

    public function getCity0() {
        return $this->hasOne(City::className(), ['id'=>'city_id']);
    }

    public function getClickPhoneCount() {
        $action = Action::find()
            ->where([
                'type' => 'click_phone',
                'subject' => 'resume',
                'subject_id' => $this->id
            ])
            ->one();
        if($action)
            return $action->count;
        else
            return 0;
    }
}