<?php

namespace backend\modules\views\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Views;

/**
 * ViewsSearch represents the model behind the search form of `common\models\Views`.
 */
class ViewsSearch extends Views
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'vacancy_id', 'viewer_id', 'dt_view'], 'integer'],
            [['options'], 'safe'],
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
        $query = Views::find();

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
            'vacancy_id' => $this->vacancy_id,
            'viewer_id' => $this->viewer_id,
            'dt_view' => $this->dt_view,
        ]);

        $query->andFilterWhere(['like', 'options', $this->options]);

        return $dataProvider;
    }
}
