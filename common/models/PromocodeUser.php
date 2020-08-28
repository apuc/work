<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promocode_user".
 *
 * @property int $user_id
 * @property int $promocode_id
 *
 * @property Promocode $promocode
 * @property User $user
 */
class PromocodeUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promocode_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'promocode_id'], 'required'],
            [['user_id', 'promocode_id'], 'integer'],
            [['user_id', 'promocode_id'], 'unique', 'targetAttribute' => ['user_id', 'promocode_id']],
            [['promocode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promocode::className(), 'targetAttribute' => ['promocode_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'promocode_id' => 'Promocode ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromocode()
    {
        return $this->hasOne(Promocode::className(), ['id' => 'promocode_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Запоминает использование промокода пользователем.
     * Если этот промокод уже был использован этим пользователем - возвращает false,
     * в обратном случае true
     * @param Promocode $promocode
     * @return bool
     */
    public static function register(Promocode $promocode) {
        $model = new self();
        $model->user_id = Yii::$app->user->id;
        $model->promocode_id = $promocode->id;
        return $model->save();
    }
}
