<?php

namespace frontend\modules\vacancy\classes;

use common\classes\Debug;
use common\models\Category;
use common\models\City;
use common\models\Country;
use common\models\EmploymentType;
use common\models\Professions;
use common\models\Region;
use common\models\Skill;
use common\models\SpecFilters;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Vacancy;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "vacancy".
 *
 * @property integer $min_salary
 * @property integer $max_salary
 * @property integer $city_disable
 * @property array|string $category_ids
 * @property array|string $employment_type_ids
 * @property array|string $experience_ids
 * @property string $search_text
 * @property string $first_query_param
 * @property string $second_query_param
 *
 * @property City|null $current_city
 * @property Country|null $current_country
 * @property Category|null $current_category
 * @property Professions|null $current_profession
 * @property SpecFilters|null $current_spec_filter
 */

class VacancySearch extends Vacancy
{
    public $current_city;
    public $current_country;
    public $current_category;
    public $current_profession;
    public $current_spec_filter;
    public $category_ids;
    public $employment_type_ids;
    public $experience_ids;
    public $search_text;
    public $first_query_param;
    public $second_query_param;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['min_salary', 'max_salary'], 'integer'],
            [['category_ids', 'employment_type_ids', 'experience_ids', 'search_text', 'first_query_param', 'second_query_param'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Vacancy::find()
            ->joinWith(['category', 'company', 'city0', 'mainCategory as mainCategory'])
            ->where([Vacancy::tableName().'.status' => Vacancy::STATUS_ACTIVE])
            ->orderBy('update_time DESC')
            ->distinct();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $this->category_ids = json_decode($this->category_ids);
        $this->employment_type_ids = json_decode($this->employment_type_ids);
        $this->experience_ids = json_decode($this->experience_ids);
        if($this->second_query_param) {
            $this->current_city = City::findOne(['slug'=>$this->first_query_param]);
            if(!$this->current_city)
                $this->current_country = Country::findOne(['slug'=>$this->first_query_param]);
            if($this->current_category = Category::findOne(['slug'=>$this->second_query_param])) {
                $this->category_ids = [$this->current_category->id];
            }
            else if($this->current_profession = Professions::findOne(['slug'=>$this->second_query_param])) {
                $this->search_text = $this->current_profession->title;
            } else if ($this->current_spec_filter = SpecFilters::findOne(['slug'=>$this->second_query_param])) {
                $query->andWhere([$this->current_spec_filter->sign, $this->current_spec_filter->field_name, $this->current_spec_filter->value]);
            }
            if((!$this->current_city && !$this->current_country) || (!$this->current_category && !$this->current_profession && !$this->current_spec_filter)) {
                throw new NotFoundHttpException();
            }
        } else if ($this->first_query_param) {
            $this->current_city = City::findOne(['slug'=>$this->first_query_param, 'status'=>1]);
            if(!$this->current_city) {
                if($this->current_category = Category::findOne(['slug'=>$this->first_query_param]))
                    $this->category_ids=[$this->current_category->id];
                else if($this->current_profession = Professions::findOne(['slug'=>$this->first_query_param]))
                    $this->search_text = $this->current_profession->title;
                else if ($this->current_country = Country::findOne(['slug'=>$this->first_query_param])) {

                } else if ($this->current_spec_filter = SpecFilters::findOne(['slug'=>$this->first_query_param, 'status'=>1])) {
                    $query->andWhere([$this->current_spec_filter->sign, $this->current_spec_filter->field_name, $this->current_spec_filter->value]);
                }
            }
        }
        if($this->current_city && !$this->current_country) {
            $this->current_country = $this->current_city->region->country;
        }
        if(!$this->current_city && $this->current_country) {
            $query->joinWith('city0.region');
            $query->andWhere([Region::tableName().'.country_id'=>$this->current_country->id]);
        }
        if($this->employment_type_ids) {
            $query->joinWith(['employment_type']);
            $query->andWhere(['employment_type.id' => $this->employment_type_ids]);
        }
        $query->andFilterWhere(['>=', 'max_salary', $this->min_salary])
            ->andFilterWhere(['<=', 'min_salary', $this->max_salary]);
        if($this->category_ids) {
            $query->andWhere(['or', ['IN', 'category.id', $this->category_ids], ['IN', 'main_category_id', $this->category_ids]]);
        }
        if($this->current_city)
            $query->andFilterWhere(['city_id' => $this->current_city->id]);
        if ($this->experience_ids) {
            $or = ['or'];
            foreach ($this->experience_ids as $experience_id) {
                $or[] = ['=', 'work_experience', $experience_id];
            }
            $query->andWhere($or);
        }
        if ($this->search_text) {
            $query->joinWith(['skill']);
            $query->andWhere(['or',
                ['like', 'post', $this->search_text],
                ['like', 'responsibilities', $this->search_text],
                ['like', 'qualification_requirements', $this->search_text],
                ['like', 'working_conditions', $this->search_text],
                ['like', 'working_conditions', $this->search_text],
                ['like', Skill::tableName().'.name', $this->search_text]
            ]);
        }
        $get = $_GET;
        unset($get['first_query_param'], $get['second_query_param']);
        $dataProvider->pagination = new Pagination([
            'defaultPageSize' => 10,
            'params' => $get,
            'route' => Yii::$app->request->getPathInfo()
        ]);
        return $dataProvider;
    }
}
