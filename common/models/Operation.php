<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "operation".
 *
 * @property int $id
 * @property int $service_price_id
 * @property float $price
 * @property int $owner
 * @property int $created_at
 *
 * @property ServicePrice $servicePrice
 */
class Operation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operation';
    }

    public function extraFields()
    {
        return ['servicePrice'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_price_id', 'created_at', 'owner'], 'integer'],
            [['price'], 'number'],
            [['service_price_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServicePrice::className(), 'targetAttribute' => ['service_price_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_price_id' => 'Service Price ID',
            'price' => 'Цена',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicePrice()
    {
        return $this->hasOne(ServicePrice::className(), ['id' => 'service_price_id']);
    }

    public static function createOperation(ServicePrice $servicePrice, $price = null) {
        $model = new self();
        $model->service_price_id = $servicePrice->id;
        $model->owner = Yii::$app->user->id;
        $model->created_at = time();
        if ($price === null) {
            $model->price = $servicePrice->price;
        } else {
            $model->price = $price;
        }
        $model->save();
    }
}
