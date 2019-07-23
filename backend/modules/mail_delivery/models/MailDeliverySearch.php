<?php


namespace backend\modules\mail_delivery\models;


use yii\data\ActiveDataProvider;

class MailDeliverySearch extends MailDelivery
{
    public function search($params)
    {
        $query = MailDelivery::find();
        $query->select(['id', 'email', 'template', 'status', 'dt_send', 'subject']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        return $dataProvider;
    }
}