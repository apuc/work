<?php

use common\models\Promocode;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Promocode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promocode-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php if (Yii::$app->controller->action->uniqueId === 'payment/promocode/create-multiple'): ?>
        <p>Промокоды должны быть резделены пробелом</p>
    <?php endif; ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'action')->dropDownList(Promocode::getActions()) ?>

    <?= $form->field($model, 'usages_left')->textInput(['type' => 'number', 'min' => 0])->label('Осталось использований(оставьте поле пустым, если не хотите ограничивать количество использований)') ?>

    <?= $form->field($model, 'active_until')->widget(DatePicker::classname(), [
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ],
        'options' => [
            'autocomplete' => 'off'
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
