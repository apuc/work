<?php

use yii\helpers\Html; ?>
<div class="mail-form">
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

    <?= $form->field($model, 'email'); ?>

    <?= Html::label('User'); ?>
    <?php
    echo \kartik\select2\Select2::widget([
       'model' => $model,
       'attribute' => 'user_id',
       'data' => \common\models\User::getUserList(),
        'options' => ['placeholder' => 'Начните вводить...','class' => 'form-control'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>

    <?= $form->field($model, 'template'); ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\SendMail::getStatusList()); ?>

    <?= $form->field($model, 'subject'); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

</div>
