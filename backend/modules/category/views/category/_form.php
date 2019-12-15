<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <label class="control-label" for="city-image">Фотография(398*387)</label>
    <div class="media__upload_img"><img src="<?= $model->image; ?>" width="100px"/></div>
    <?=InputFile::widget([
        'language' => 'ru',
        'controller' => 'elfinder',
        // вставляем название контроллера, по умолчанию равен elfinder
        'filter' => 'image',
        // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
        'name' => 'Category[image]',
        'id' => 'category-image',
        'template' => '<div class="input-group">{input}<span class="span-btn">{button}</span></div>',
        'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
        'buttonOptions' => ['class' => 'btn btn-primary'],
        'value' => $model->image,
        'buttonName' => 'Выбрать фотографию',
    ]);
    ?>
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title_with_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description_with_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'header_with_city')->textInput(['maxlength' => true]) ?>

    <p>
        Для мета полей, учитывающих город: {city}: город, {region}: регион
    </p>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
