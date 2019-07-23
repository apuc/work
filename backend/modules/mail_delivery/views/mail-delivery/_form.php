<?php

use yii\helpers\Html; ?>
<div class="mail-form">
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

    <?= $form->field($model, 'email'); ?>

    <?= $form->field($model, 'template'); ?>

    <?= $form->field($model, 'status'); ?>

    <?= $form->field($model, 'dt_send'); ?>

    <?= $form->field($model, 'subject'); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

</div>
