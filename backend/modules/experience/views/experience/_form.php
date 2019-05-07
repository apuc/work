<?php

use common\models\Experience;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Experience */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="experience-form">

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

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'month_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'month_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'responsibility')->textarea() ?>

    <?= $form->field($model, 'status')->dropDownList([
        Experience::STATUS_ACTIVE => 'Активен',
        Experience::STATUS_INACTIVE => 'Не активен',
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
