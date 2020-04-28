<?php


namespace backend\modules\spec_filters\models;

use common\models\SpecFilters;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * Class SpecFiltersSearch
 * @package backend\modules\spec_filters\models
 */
class SpecFiltersSearch extends SpecFilters
{
    public function rules()
    {
        return [
            [['id', 'dynamic', 'status'], 'integer'],
            [['slug', 'field_name', 'name', 'value'], 'string', 'max' => 255],
            [['sign'], 'string', 'max' => 15],
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
        //\common\classes\Debug::dd($params);
        $query = SpecFilters::find();

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
            'dynamic' => $this->dynamic,
            'status' => $this->status,
        ]);
        if($this->sign) {
            $query->andFilterWhere(['sign' => self::$signs[$this->sign]]);
        }

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
        $query->andFilterWhere(['like', 'field_name', $this->field_name]);
        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
