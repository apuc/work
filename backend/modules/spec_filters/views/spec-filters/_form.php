<?php

use common\models\Vacancy;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SpecFilters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spec_filters-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'field_name')->dropDownList((new Vacancy())->attributeLabels()); ?>
    <?= $form->field($model, 'sign')->dropDownList(['=' => 'Равно', '<' => 'Меньше', '>' => 'Больше', '<=' => 'Меньше или равно', '>=' => 'Больше или равно']); ?>
    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'dynamic')->dropDownList(['Нет', 'Да']); ?>
    <?= $form->field($model, 'status')->dropDownList(['Отключен', 'Включен']); ?>
    <label class="control-label" for="spec_filters-image">Иконка</label>
    <div class="media__upload_img"><img src="<?= $model->icon; ?>" width="75px"/></div>
    <?=\mihaildev\elfinder\InputFile::widget([
        'language' => 'ru',
        'controller' => 'elfinder',
        // вставляем название контроллера, по умолчанию равен elfinder
        'filter' => 'image',
        // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
        'name' => 'SpecFilters[icon]',
        'id' => 'spec_filters-icon',
        'template' => '<div class="input-group">{input}<span class="span-btn">{button}</span></div>',
        'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
        'buttonOptions' => ['class' => 'btn btn-primary'],
        'value' => $model->icon,
        'buttonName' => 'Выбрать иконку',
    ]);
    ?>
    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>