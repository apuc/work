<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Views */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="views-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_id')->textInput() ?>

    <?= $form->field($model, 'vacancy_id')->textInput() ?>

    <?= $form->field($model, 'viewer_id')->textInput() ?>

    <?= $form->field($model, 'dt_view')->textInput() ?>

    <?= $form->field($model, 'options')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
