<?php

use common\models\Employer;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Employer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::className(),
        [
            'data' => ArrayHelper::map(\dektrium\user\models\User::find()->all(), 'id', 'username'),
            'options' => ['placeholder' => 'Начните вводить логин пользователя ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'second_name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'birth_date')->widget(DatePicker::className(), [
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
            ]
    ])?>

    <?= $form->field($model, 'status')->dropDownList([
        Employer::STATUS_ACTIVE => 'Активен',
        Employer::STATUS_INACTIVE => 'Не активен',
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
