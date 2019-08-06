<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Views */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="views-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject_type')->dropDownList([
            'резюме' => 'Resume',
            'вакансия' => 'Vacancy'
    ]);?>

    <?= $form->field($model, 'subject_id')->textInput() ?>

    <?= $form->field($model, 'viewer_id')->widget(Select2::className(),
        [
            'data' => \common\models\Views::getAllUsers(),
            'options' => ['placeholder' => 'Начните вводить имя пользователя...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?php
    echo '<label> Выберите дату просмотра</label>';
    echo '<br>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'dt_view',
        'language' => 'ru',
    ]);
    ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
