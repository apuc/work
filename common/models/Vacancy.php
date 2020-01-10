<?php
namespace common\models;

use apuc\channels_webhook\behaviors\WebHookBehavior;
use common\models\base\WorkActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\View;

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
 * @property integer $hot
 * @property integer $notification_status
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $owner
 * @property integer $update_time
 *
 * @property Company $company
 * @property EmploymentType $employment_type
 * @property VacancySkill[] $vacancy_skill
 * @property Skill[] $skill
 * @property Category[] $category
 * @property VacancyCategory[] $vacancy_category
 * @property bool $can_update
 * @property integer $countViews
 */
class Vacancy extends WorkActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const NOTIFICATION_STATUS_OK=0;
    const NOTIFICATION_STATUS_1_WEEK=1;
    const NOTIFICATION_STATUS_2_WEEKS=2;

    const UPDATE_MIN_SEC_PASSED = 86400;

    public static $experiences = [
      'Не имеет значения', 'Менее года', '1 год', '2 года'
    ];

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
            [['company_id', 'min_salary', 'max_salary', 'employment_type_id', 'status', 'work_experience', 'created_at', 'updated_at', 'update_time', 'hot', 'notification_status'], 'integer'],
            [['post', 'education', 'video', 'address', 'home_number', 'city'], 'string', 'max' => 255],
            [['responsibilities', 'qualification_requirements', 'working_conditions'], 'string'],
            [['company_id', 'post'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['company', 'employment_type', 'vacancy_skill', 'skill', 'can_update', 'category', 'views0', 'countViews'];
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
            'hot' => 'Горячая',
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


    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getExperienceId($experience)
    {
        return array_search($experience, self::$experiences);
    }

    /**
     * @return bool
     */
    public function getCan_update()
    {
        return (time()-self::UPDATE_MIN_SEC_PASSED) > $this->update_time;
    }

    public function getViews0()
    {
        return $this->hasMany(Views::className(), ['subject_id' => 'id'])->where(['subject_type' => 'Vacancy']);
    }

    public function getCountViews()
    {
        return Views::find()->where(['subject_id' => $this->id])->andWhere(['subject_type' => 'Vacancy'])->count();
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
            $title=str_replace('{city}', $city->name, $category->meta_title_with_city);
            $title=str_replace('{region}', $city->region->name, $title);
            $description=str_replace('{city}', $city->name, $category->meta_description_with_city);
            $description=str_replace('{region}', $city->region->name, $description);
            $header=str_replace('{city}', $city->name, $category->header_with_city);
            $header=str_replace('{region}', $city->region->name, $header);
        }
        if($city &&(!$title || !$description || !$header)) {
            $title=$title?:$city->meta_title;
            $description=$description?:$city->meta_description;
            $header=$header?:$city->header;
        }
        if($category &&(!$title || !$description || !$header)) {
            $title=$title?:$category->meta_title;
            $description=$title?:$category->meta_description;
            $header=$header?:$category->header;
        }
        $title=$title?:KeyValue::findValueByKey('vacancy_search_page_title')?:"Поиск Вакансий";
        $description=$description?:KeyValue::findValueByKey('vacancy_search_page_description')?:"Поиск Вакансий";
        $header=$header?:KeyValue::findValueByKey('vacancy_search_page_h1')?:"Поиск Вакансий";
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
     * Получение урл для страницы поиска вакансий, с учётом переданных города и категории. Если город не указывать, будет использован город из cookie
     *
     */
    public static function getSearchPageUrl($category_slug = false, $city_slug=false) {
        $url = "/vacancy";
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
}