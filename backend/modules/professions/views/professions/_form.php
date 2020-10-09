<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\professions\models\Professions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="professions-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col col-lg-4">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'genitive')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col col-lg-4">
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'instrumental')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col col-lg-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
