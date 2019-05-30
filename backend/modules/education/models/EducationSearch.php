<?php

namespace backend\modules\education\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Education;

/**
 * EducationSearch represents the model behind the search form of `common\models\Education`.
 */
class EducationSearch extends Education
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'resume_id', 'year_from', 'year_to', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'academic_degree', 'specialization', 'faculty'], 'safe'],
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
        $query = Education::find()->orderBy('id DESC');

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
            'resume_id' => $this->resume_id,
            'year_from' => $this->year_from,
            'year_to' => $this->year_to,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'faculty', $this->faculty])
            ->andFilterWhere(['like', 'academic_degree', $this->academic_degree])
            ->andFilterWhere(['like', 'specialization', $this->specialization]);

        return $dataProvider;
    }
}
