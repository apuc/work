<?php

namespace backend\modules\views\models;

use common\classes\Debug;
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
            [['id', 'subject_id', 'viewer_id', 'dt_view'], 'integer'],
            [['options'], 'safe'],
            [['subject_type'], 'string'],
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
        if (empty($this->dt_view)) {
            $this->dt_view = null;
        } else {
            $this->dt_view = strtotime($this->dt_view);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'subject_id' => $this->subject_id,
        ]);

        $query->andFilterWhere(['like', 'subject_type', $this->subject_type]);

        $query->andFilterWhere(['like', 'options', $this->options]);

        if(isset($this->dt_view)) {
            $query->andFilterWhere(['>=', 'dt_view', $this->dt_view]);
            $query->andFilterWhere(['<=', 'dt_view', $this->dt_view + 86400]);
        }

        if($this->viewer_id === '0') {
            $query->andWhere(['viewer_id' => null]);
        } else {
            $query->andFilterWhere(['viewer_id' => $this->viewer_id]);
        }

        return $dataProvider;
    }
}
