<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\views\models\ViewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="views-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'company_id') ?>

    <?= $form->field($model, 'vacancy_id') ?>

    <?= $form->field($model, 'viewer_id') ?>

    <?= $form->field($model, 'dt_view') ?>

    <?php // echo $form->field($model, 'options') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
