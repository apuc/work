<?php

namespace common\models;

use common\models\base\WorkActiveRecord;
use Yii;

/**
 * This is the model class for table "geobase_city".
 *
 * @property int $id
 * @property string $name
 * @property string $prepositional
 * @property string $image
 * @property string $region_id
 * @property string $latitude
 * @property string $longitude
 * @property string $status
 *
 */
class City extends WorkActiveRecord
{
    const TYPE_HIDDEN = 0;
    const TYPE_SHOWN = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geobase_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'prepositional', 'image'], 'string', 'max' => 50],
            [['region_id', 'status'], 'integer'],
            [['latitude', 'longitude'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
          'latitude' => 'Широта',
            'longitude' => 'Долгота',
            'region_id' => 'Область',
            'image' => 'Фотография',
        ];
    }

    public static function getStatusList()
    {
        return [
            self::TYPE_HIDDEN => 'Скрыт',
            self::TYPE_SHOWN => 'Выводится',
        ];
    }

    public static function getStatusName($id)
    {
        return self::getStatusList()[$id];
    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
}
