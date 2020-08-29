<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "FK_payment".
 *
 * @property int $id
 * @property float $amount Сумма заказа
 * @property int $operation_number Номер операции Free-Kassa
 * @property int $company_id Компания, на счёт которой зачислены средства
 * @property string $email Email плательщика
 * @property string $phone Телефон плательщика
 * @property int $currency_id Электронная валюта
 * @property string $sign Подпись
 * @property int $date Дата
 *
 * @property Company $company
 */
class FKPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'FK_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'operation_number'], 'required'],
            [['sign'], 'unique'],
            [['amount'], 'number'],
            [['operation_number', 'company_id', 'currency_id', 'date'], 'integer'],
            [['email', 'phone', 'sign'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Сумма заказа',
            'operation_number' => 'Номер операции Free-Kassa',
            'company_id' => 'Компания, на счёт которой зачислены средства',
            'email' => 'Email плательщика',
            'phone' => 'Телефон плательщика',
            'currency_id' => 'Электронная валюта',
            'sign' => 'Подпись',
            'date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(FKCurrency::className(), ['id' => 'currency_id']);
    }
}
