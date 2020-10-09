<?php
namespace backend\modules\cities\models;

use common\models\City;
use yii\data\ActiveDataProvider;

class CitiesSearch extends City
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
            [['prepositional', 'image', 'slug', 'meta_title', 'header', 'resume_meta_title', 'resume_header'], 'string', 'max' => 255],
            [['meta_description', 'bottom_text', 'resume_meta_description', 'resume_bottom_text'], 'string'],
            [['region_id', 'status'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = City::find()->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'region_id' => $this->region_id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'prepositional', $this->prepositional]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
        $query->andFilterWhere(['like', 'meta_title', $this->meta_title]);
        $query->andFilterWhere(['like', 'meta_description', $this->meta_description]);
        $query->andFilterWhere(['like', 'header', $this->header]);
        $query->andFilterWhere(['like', 'bottom_text', $this->bottom_text]);
        $query->andFilterWhere(['like', 'resume_meta_title', $this->resume_meta_title]);
        $query->andFilterWhere(['like', 'resume_meta_description', $this->resume_meta_description]);
        $query->andFilterWhere(['like', 'resume_header', $this->resume_header]);
        $query->andFilterWhere(['like', 'resume_bottom_text', $this->resume_bottom_text]);

        return $dataProvider;
    }
}