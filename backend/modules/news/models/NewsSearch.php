<?php

namespace backend\modules\news\models;

use common\classes\Debug;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\News;

/**
 * NewsSearch represents the model behind the search form of `common\models\News`.
 */
class NewsSearch extends News
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'dt_create', 'dt_update', 'dt_public'], 'integer'],
            [['title', 'description', 'content', 'dt_public', 'dt_create'], 'safe'],
            [['img'], 'string']
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
        $query = News::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (empty($this->dt_create)) {
            $this->dt_create = null;
        } else {
            $this->dt_create = strtotime($this->dt_create);
        }

        if (empty($this->dt_public)) {
            $this->dt_public = null;
        } else {
            $this->dt_public = strtotime($this->dt_public);
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content]);

        if(isset($this->dt_create)) {
            $query->andFilterWhere(['>=', 'dt_create', $this->dt_create]);
            $query->andFilterWhere(['<=', 'dt_create', $this->dt_create + 86400]);
        }

        if(isset($this->dt_public)) {
            $query->andFilterWhere(['>=', 'dt_public', $this->dt_public]);
            $query->andFilterWhere(['<=', 'dt_public', $this->dt_public + 86400]);
        }

        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
