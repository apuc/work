<?php

namespace backend\modules\payment\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FKPayment;

/**
 * FKPaymentSearch represents the model behind the search form of `common\models\FKPayment`.
 */
class FKPaymentSearch extends FKPayment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'operation_number', 'company_id', 'currency_id'], 'integer'],
            [['amount'], 'number'],
            [['email', 'phone', 'sign'], 'safe'],
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
        $query = FKPayment::find()->orderBy('id DESC');

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
            'amount' => $this->amount,
            'operation_number' => $this->operation_number,
            'company_id' => $this->company_id,
            'currency_id' => $this->currency_id,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'sign', $this->sign]);

        return $dataProvider;
    }
}
