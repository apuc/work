<?php
namespace backend\modules\cities\models;

use common\classes\Debug;
use common\models\City;
use yii\data\ActiveDataProvider;

class CitiesSearch extends City
{
    public function search($params)
    {
        $query = City::find()->orderBy('id DESC');

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

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['region_id' => $this->region_id]);


        return $dataProvider;
    }
}