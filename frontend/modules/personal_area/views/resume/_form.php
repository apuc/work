<?php

use common\models\Resume;
use common\models\Skill;
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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?= $form->field($model, 'employment_type_id')->dropDownList(ArrayHelper::map(\common\models\EmploymentType::find()->all(), 'id', 'name'), [ 'class' => 'form-control', 'prompt' => '' ] ) ?>

    <?= $form->field($model, 'schedule_id')->textInput() ?>

    <?= $form->field($model, 'skill')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Skill::find()->asArray()->all(), 'id', 'name'),
        'options' => [
                'placeholder' => 'Укажите ваши умения',
                'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>

    <?= $form->field($model, 'status')->dropDownList([
        Resume::STATUS_ACTIVE => 'Активно',
        Resume::STATUS_INACTIVE => 'Не активно',
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
