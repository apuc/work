<?php

namespace backend\modules\vacancy\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Vacancy;

/**
 * VacancySearch represents the model behind the search form of `common\models\Vacancy`.
 *
 *
 * @property integer $category_id
 */
class VacancySearch extends Vacancy
{
    public $category_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'city_id', 'min_salary', 'max_salary', 'employment_type_id', 'status', 'created_at', 'updated_at', 'publisher_id', 'category_id'], 'integer'],
            [['post', 'responsibilities', 'qualification_requirements', 'work_experience', 'education', 'working_conditions', 'video', 'address', 'home_number'], 'safe'],
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
        $query = Vacancy::find()->orderBy('id DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'company_id' => $this->company_id,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'employment_type_id' => $this->employment_type_id,
            'city_id' => $this->city_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'publisher_id' => $this->publisher_id,
        ]);
        if ($this->category_id) {
            $query->joinWith('vacancy_category');
            $query->andWhere(['or', ['main_category_id'=>$this->category_id], ['vacancy_category.category_id' => $this->category_id]]);
        }

        $query->andFilterWhere(['like', 'post', $this->post])
            ->andFilterWhere(['like', 'responsibilities', $this->responsibilities])
            ->andFilterWhere(['like', 'qualification_requirements', $this->qualification_requirements])
            ->andFilterWhere(['like', 'work_experience', $this->work_experience])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'working_conditions', $this->working_conditions])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'home_number', $this->home_number]);

        return $dataProvider;
    }
}
