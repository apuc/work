<?php

namespace common\models;

use apuc\channels_webhook\behaviors\WebHookBehavior;
use common\classes\MoneyFormat;
use common\models\base\WorkActiveRecord;
use Yii;
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
 * @property int $city_id
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
 * @property integer $description
 * @property integer $main_category_id
 * @property integer $publisher_id
 * @property integer $get_update_id
 *
 * @property Company $company
 * @property EmploymentType $employment_type
 * @property VacancySkill[] $vacancy_skill
 * @property Skill[] $skill
 * @property Category[] $category
 * @property Category $mainCategory
 * @property VacancyCategory[] $vacancy_category
 * @property bool $can_update
 * @property integer $countViews
 * @property City $city0
 * @property int $clickPhoneCount
 * @property User $publisher
 * @property VacancyProfession[] $vacancyProfessions
 * @property Professions[] $professions
 */
class Vacancy extends WorkActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const NOTIFICATION_STATUS_OK = 0;
    const NOTIFICATION_STATUS_1_WEEK = 1;
    const NOTIFICATION_STATUS_2_WEEKS = 2;

    const UPDATE_MIN_SEC_PASSED = 86400;

    const SOFT_DELETE = 1;

    const GET_UPDATE_ID = 1;
    const NOT_GET_UPDATE_ID = 0;

    public static $experiences = [
        'Без опыта работы', 'От 1 года', 'От 3 лет', 'От 5 лет'
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
            'webHook' => ['class' => WebHookBehavior::className(),
                'url' => 'https://webhooks.mychannels.gq/rabota/13'
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'min_salary', 'max_salary', 'employment_type_id', 'status', 'work_experience', 'created_at', 'updated_at', 'update_time', 'hot', 'notification_status', 'city_id', 'main_category_id', 'publisher_id', 'get_update_id'], 'integer'],
            [['post', 'education', 'video', 'address', 'home_number'], 'string', 'max' => 255],
            [['responsibilities', 'qualification_requirements', 'working_conditions', 'description'], 'string'],
            [['company_id', 'post', 'main_category_id'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['company', 'employment_type', 'vacancy_skill', 'skill', 'can_update', 'category', 'views0', 'countViews', 'city0', 'mainCategory', 'clickPhoneCount'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
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
            'city_id' => 'Город',
            'address' => 'Адрес офиса',
            'home_number' => 'Номер дома',
            'employment_type_id' => 'Вид занятости',
            'hot' => 'Горячая',
            'status' => 'Статус',
            'created_at' => 'Создана',
            'updated_at' => 'Изменена',
            'description' => 'Описание',
            'main_category_id' => 'Главная категория',
            'publisher_id' => 'Опубликовавший',
            'get_update_id' => 'Получить связаные профессии',
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
    public function getPublisher()
    {
        return $this->hasOne(User::className(), ['id' => 'publisher_id']);
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
     * @inheritdoc
     */
    public function getMainCategory()
    {
        return $this->hasOne(Category::className(), ['id'=>'main_category_id']);
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
        return (time() - self::UPDATE_MIN_SEC_PASSED) > $this->update_time;
    }

    public function getViews0()
    {
        return $this->hasMany(Views::className(), ['subject_id' => 'id'])->where(['subject_type' => 'Vacancy']);
    }

    public function getCountViews()
    {
        return Views::find()->where(['subject_id' => $this->id])->andWhere(['subject_type' => 'Vacancy'])->count();
    }

    public function getCity0() {
        return $this->hasOne(City::className(), ['id'=>'city_id']);
    }

    public function getMoneyString($uc_first=true) {
        if ($this->min_salary && $this->max_salary)
            return MoneyFormat::getFormattedAmount($this->min_salary) . '-' . MoneyFormat::getFormattedAmount($this->max_salary) . '₽';
        elseif ($this->min_salary)
            return MoneyFormat::getFormattedAmount($this->min_salary) . '₽';
        elseif ($this->max_salary)
            return MoneyFormat::getFormattedAmount($this->max_salary) . '₽';
        else if($uc_first)
            return 'Зарплата договорная';
        else return 'зарплата договорная';
    }

    /**
     * @param bool|string $category_slug
     * @param bool|string $city_slug
     * @return string
     *
     * Получение урл для страницы поиска вакансий, с учётом переданных города и категории. Если город не указывать, будет использован город из cookie
     *
     */
    public static function getSearchPageUrl($category_slug = false, $city_slug = false, $profession_slug = false, $country_slug = false)
    {
        $url = "/vacancy";
        if ($city_slug) {
            $url .= "/$city_slug";
        } else if ($country_slug) {
            $url .= "/$country_slug";
        } else if (Yii::$app->request->cookies['country_slug']) {
            $url .= "/".Yii::$app->request->cookies['country_slug'];
        }
        if ($category_slug) {
            $url .= "/$category_slug";
        } else if($profession_slug) {
            $url .= "/$profession_slug";
        }
        return $url;
    }

    /**
     * @param int $hoursCount
     * @param int $status
     * @return array|ActiveRecord[]
     *
     * получение новых вакансий за определенное кол-во времени
     */
    public static function getNewVacancy($hoursCount = 24, $status = self::STATUS_ACTIVE)
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
     * получение новых вакансий за определенное кол-во времени
     */
    public static function getUpdateVacancy($hoursCount = 24, $status = self::STATUS_ACTIVE)
    {
        return self::find()
            ->where('updated_at > UNIX_TIMESTAMP() - ' . $hoursCount . '*60*60')
            ->andWhere('created_at < UNIX_TIMESTAMP() - ' . $hoursCount . '*60*60')
            ->andWhere(['status' => $status])
            ->all();
    }

    public function getClickPhoneCount() {
        $action = Action::find()
            ->where([
                'type' => 'click_phone',
                'subject' => 'vacancy',
                'subject_id' => $this->id
            ])
            ->one();
        if($action)
            return $action->count;
        else
            return 0;
    }

    public function getVacancyProfessions()
    {
        return $this->hasMany(VacancyProfession::className(), ['vacancy_id' => 'id'])->orderBy('match_type')->limit(4);
    }

    public  function  getProfessions()
    {
        return $this->hasMany(Professions::className(), ['id' => 'profession_id'])
            ->via('vacancyProfessions');
    }
}