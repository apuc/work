<?php

namespace common\models;

use common\models\base\WorkActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "banner".
 *
 * @property int $id
 * @property int $company_id
 * @property string $description
 * @property string $image_url
 * @property string $logo_url
 * @property int $is_active
 * @property int $priority
 * @property int $owner
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Company $company
 * @property User $ownerUser
 * @property BannerLocation[] $bannerLocations
 */
class Banner extends WorkActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const DESCRIPTION_MAX_LENGTH = 125;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner';
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'description'], 'required'],

            ['company_id', 'exist', 'targetRelation' => 'company'],
            ['owner', 'exist', 'targetRelation' => 'ownerUser'],
            ['description', 'string', 'max' => static::DESCRIPTION_MAX_LENGTH],

            ['is_active', 'default', 'value' => static::STATUS_INACTIVE],
            ['is_active', 'in', 'range' => [static::STATUS_ACTIVE, static::STATUS_INACTIVE]],

            ['priority', 'integer', 'min' => 1],

            ['logo_url', 'string', 'max' => 255],
            ['image_url', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'company_id' => 'Компания',
            'description' => 'Описание',
            'image_url' => 'Изображение',
            'logo_url' => 'Логотип компании',
            'is_active' => 'Включен',
            'priority' => 'Приоритет',
            'owner' => 'Владелец',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен'
        ];
    }


    /**
     * @return false|string
     */
    public function getHumanCreatedAt()
    {
        return date('d.m.Y H:i:s', $this->created_at);
    }


    /**
     * @return false|string
     */
    public function getHumanUpdatedAt()
    {
        return date('d.m.Y H:i:s', $this->updated_at);
    }


    /**
     * @return ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getOwnerUser()
    {
        return $this->hasOne(User::className(), ['id' => 'owner']);
    }


    /**
     * @return ActiveQuery
     */
    public function getBannerLocations()
    {
        return $this->hasMany(BannerLocation::className(), ['banner_id' => 'id'])->inverseOf('banner');
    }

    public function canAccess($user_id){
        $access=false;
        foreach ($this->company->userCompany as $user_company){
            if($user_company->user_id==Yii::$app->user->id)
                $access=true;
        }
        if($this->owner != Yii::$app->user->id && !$access)
            return false;
        return true;
    }
}
