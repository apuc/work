<?php

use common\models\Education;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Education */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="education-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'resume_id')->widget(Select2::className(),
        [
            'data' => ArrayHelper::map(\common\models\Resume::find()->all(), 'id', 'title'),
            'options' => ['placeholder' => 'Начните вводить название резюме ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'faculty')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'academic_degree')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'specialization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        Education::STATUS_ACTIVE => 'Активен',
        Education::STATUS_INACTIVE => 'Не активен',
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
