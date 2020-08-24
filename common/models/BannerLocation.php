<?php

namespace common\models;

use common\models\base\WorkActiveRecord;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "banner_location".
 *
 * @property int $id
 * @property int $banner_id
 * @property int $category_id
 * @property int $city_id
 *
 * @property bool $hasCity
 * @property bool $hasCategory
 *
 * @property Banner $banner
 * @property City $city
 * @property Category $category
 *
 */
class BannerLocation extends WorkActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['banner_id', 'category_id', 'city_id'], 'integer'],
            [['banner_id', 'city_id'], 'required'],
            ['banner_id', 'exist', 'targetRelation' => 'banner', 'skipOnEmpty' => false],
            ['category_id', 'exist', 'targetRelation' => 'category'],
            ['city_id', 'exist', 'targetRelation' => 'city'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'banner_id' => 'Баннер',
            'city_id' => 'Город',
            'category_id' => 'Категория'
        ];
    }


    /**
     * @return bool
     */
    public function getHasCity() : bool
    {
        return isset($this->city);
    }


    /**
     * @return bool
     */
    public function getHasCategory() : bool
    {
        return isset($this->category);
    }


    /**
     * @return ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banner::className(), ['id' => 'banner_id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
