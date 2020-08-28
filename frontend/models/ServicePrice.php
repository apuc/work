<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_price".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $price
 */
class ServicePrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['name', 'alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'alias' => 'Alias',
            'price' => 'Price',
        ];
    }
}
