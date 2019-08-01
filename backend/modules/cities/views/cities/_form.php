<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>
<div class="cities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'region_id'); ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\City::getStatusList()); ?>
    <?= $form->field($model, 'longitude'); ?>
    <?= $form->field($model, 'latitude'); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
