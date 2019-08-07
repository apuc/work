<?php
namespace backend\modules\mail_delivery\models;

use common\classes\Debug;
use yii\data\ActiveDataProvider;

class MailDeliverySearch extends MailDelivery
{
    public function rules()
    {
        return [
           [['user_id', 'template', 'subject', 'email', 'dt_send'], 'safe'],
            [['status'], 'integer']
        ];
    }

    public function search($params)
    {
        $query = MailDelivery::find();
        $query->select(['id', 'email', 'template', 'status', 'dt_send', 'subject']);

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
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'email', $this->email]);

        if(!empty($this->dt_send)) {
            $query->andFilterWhere(['>=', 'dt_send', strtotime($this->dt_send)]);
            $query->andFilterWhere(['<=', 'dt_send', strtotime($this->dt_send) + 86400]);
        }

        $query->orderBy('id DESC');

        return $dataProvider;
    }
}