<?php

use common\models\Company;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use mihaildev\elfinder\InputFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Logo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_id')->widget(Select2::className(),
        [
            'data' => ArrayHelper::map(Company::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Начните вводить название компании ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?=InputFile::widget([
        'language' => 'ru',
        'controller' => 'elfinder',
        'filter' => 'image',
        'name' => 'Logo[image]',
        'id' => 'logo-image',
        'template' => '<div class="input-group">{input}<span class="span-btn">{button}</span></div>',
        'options' => ['class' => 'form-control itemImg banner_update_on_change', 'maxlength' => '255'],
        'buttonOptions' => ['class' => 'btn btn-primary'],
        'value' => $model->image,
        'buttonName' => 'Выбрать фотографию',
    ]);
    ?>

    <?= $form->field($model, 'active_until')->widget(DatePicker::className(), [
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
        ]
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
