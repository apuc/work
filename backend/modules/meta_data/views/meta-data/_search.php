<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\meta_data\models\MetaDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meta-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'vacancy_meta_title') ?>

    <?= $form->field($model, 'vacancy_meta_description') ?>

    <?= $form->field($model, 'vacancy_header') ?>

    <?php // echo $form->field($model, 'vacancy_meta_title_with_city') ?>

    <?php // echo $form->field($model, 'vacancy_meta_description_with_city') ?>

    <?php // echo $form->field($model, 'vacancy_header_with_city') ?>

    <?php // echo $form->field($model, 'vacancy_bottom_text') ?>

    <?php // echo $form->field($model, 'resume_meta_title') ?>

    <?php // echo $form->field($model, 'resume_meta_description') ?>

    <?php // echo $form->field($model, 'resume_header') ?>

    <?php // echo $form->field($model, 'resume_meta_title_with_city') ?>

    <?php // echo $form->field($model, 'resume_meta_description_with_city') ?>

    <?php // echo $form->field($model, 'resume_header_with_city') ?>

    <?php // echo $form->field($model, 'resume_bottom_text') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
