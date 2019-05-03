<?php

namespace common\models;

use common\models\base\WorkActiveRecord;
use Yii;

/**
 * This is the model class for table "geobase_city".
 *
 * @property int $id
 * @property string $name
 * @property string $region_id
 * @property string $latitude
 * @property string $longitude
 * @property string $status
 *
 */
class City extends WorkActiveRecord
{
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
            [['name'], 'string', 'max' => 50],
            [['region_id', 'status'], 'integer'],
            [['latitude', 'longitude'], 'safe'],
        ];
    }
}
