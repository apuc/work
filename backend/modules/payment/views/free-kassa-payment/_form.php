<?php

use common\models\Company;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FKPayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fkpayment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operation_number')->textInput() ?>

    <?= $form->field($model, 'company_id')->widget(\kartik\select2\Select2::className(), [
        'attribute' => 'company_id',
        'data' => \yii\helpers\ArrayHelper::map(Company::find()->asArray()->all(),'id', 'name'),
        'options' => ['placeholder' => 'Выберите компанию ...','class' => 'form-control'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_id')->widget(\kartik\select2\Select2::className(), [
        'attribute' => 'company_id',
        'data' => \yii\helpers\ArrayHelper::map(\common\models\FKCurrency::find()->asArray()->all(),'id', 'name'),
        'options' => ['placeholder' => 'Выберите валюту ...','class' => 'form-control'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'sign')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
