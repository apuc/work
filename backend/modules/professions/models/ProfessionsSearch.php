<?php

namespace backend\modules\professions\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\professions\models\Professions;

/**
 * ProfessionsSearch represents the model behind the search form of `backend\modules\professions\models\Professions`.
 */
class ProfessionsSearch extends Professions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'slug', 'genitive', 'instrumental'], 'safe'],
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
        $query = Professions::find();

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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'genitive', $this->genitive])
            ->andFilterWhere(['like', 'instrumental', $this->instrumental]);

        return $dataProvider;
    }
}
