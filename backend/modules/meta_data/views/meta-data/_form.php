<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetaData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meta-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <p>
        Для мета полей, учитывающих город: {city}: город, {region}: регион, {city_prep}: предложный падеж города (Донецке, Макеевке)
    </p>
    <div class="col col-lg-6">
    <?= $form->field($model, 'vacancy_meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vacancy_meta_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vacancy_header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vacancy_meta_title_with_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vacancy_meta_description_with_city')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vacancy_header_with_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vacancy_bottom_text')->textarea(['rows' => 6]) ?>
    </div>
    <?php if(!$model->profession):?>
    <div class="col col-lg-6">
    <?= $form->field($model, 'resume_meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resume_meta_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'resume_header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resume_meta_title_with_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resume_meta_description_with_city')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'resume_header_with_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resume_bottom_text')->textarea(['rows' => 6]) ?>
    </div>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'style' => 'margin-left: 15px']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
