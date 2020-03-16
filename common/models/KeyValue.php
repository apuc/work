<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "key_value".
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property string $label
 */
class KeyValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'key_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'label'], 'string'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Ключ',
            'value' => 'Значение',
            'label' => 'Описание'
        ];
    }

    public static function findValueByKey($key){
        if (!$value = Yii::$app->cache->get("key_value_$key")) {
            if($model = self::find()->where(['key' => $key])->one()) {
                Yii::$app->cache->set("key_value_$key", $model->value, 3600);
                return $model->value;
            }
            else
                return null;
        } else
            return $value;

    }

}
