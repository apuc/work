<?php

use common\models\Resume;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Resume */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resume-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employer_id')->widget(Select2::className(),
        [
            'data' => ArrayHelper::map(\common\models\Employer::find()->all(), 'id', 'second_name'),
            'options' => ['placeholder' => 'Начните вводить имя сотрудника ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?= $form->field($model, 'category')->widget(Select2::className(),
        [
            'data' => ArrayHelper::map(\common\models\Category::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Начните вводить название категории ...', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>
    <?= $form->field($model, 'employment_type')->widget(Select2::className(),
        [
            'data' => ArrayHelper::map(\common\models\EmploymentType::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Начните вводить тип занятости ...', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>
    <?= $form->field($model, 'skill')->widget(Select2::className(),
        [
            'data' => ArrayHelper::map(\common\models\Skill::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Начните вводить умение ...', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'status')->dropDownList([
        Resume::STATUS_ACTIVE => 'Активно',
        Resume::STATUS_INACTIVE => 'Не активно',
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
