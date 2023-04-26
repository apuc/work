<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mk_payment".
 *
 * @property int $id
 * @property string $transaction_id
 * @property int $payment
 * @property int $merchant
 * @property double $amount
 * @property string $sign
 * @property string $email
 * @property int $date
 * @property int $company_id
 *
 * @property Company $company
 */
class MkPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mk_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment', 'merchant', 'date', 'company_id'], 'integer'],
            [['amount'], 'number'],
            [['transaction_id', 'sign', 'email'], 'string', 'max' => 255],
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
            'transaction_id' => 'Transaction ID',
            'payment' => 'Payment',
            'merchant' => 'Merchant',
            'amount' => 'Amount',
            'sign' => 'Sign',
            'email' => 'Email',
            'date' => 'Date',
            'company_id' => 'Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
