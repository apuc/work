<?php
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>
<section class="reset-password">
    <div class="container">
        <h2>Придумайте новый пароль</h2>
        <?php $form = ActiveForm::begin([
            'id' => 'reset-password-form',
            'validateOnBlur'=>false,
            'validateOnChange'=>false,
        ]); ?>
            <?= $form->field($model, 'password1')->passwordInput(['maxlength' => true, 'placeholder'=>'Новый пароль'])->label(false) ?>
            <?= $form->field($model, 'password2')->passwordInput(['maxlength' => true, 'placeholder'=>'Повторите пароль'])->label(false) ?>
            <?= $form->field($model, 'code')->hiddenInput(['maxlength' => true])->label(false) ?>
            <?= Html::submitButton('Сохранить')?>
        <?php ActiveForm::end(); ?>
    </div>
</section>