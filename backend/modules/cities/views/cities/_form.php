<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>


<div class="cities-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col col-lg-5">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'prepositional')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'region_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Region::find()->all(), 'id', 'name')); ?>
        <?= $form->field($model, 'slug'); ?>
        <label class="control-label" for="city-image">Фотография(1920*262)</label>
        <div class="media__upload_img"><img src="<?= $model->image; ?>" width="100px"/></div>
        <?=
            InputFile::widget([
                'language' => 'ru',
                'controller' => 'elfinder',
                // вставляем название контроллера, по умолчанию равен elfinder
                'filter' => 'image',
                // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
                'name' => 'City[image]',
                'id' => 'city-image',
                'template' => '<div class="input-group">{input}<span class="span-btn">{button}</span></div>',
                'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
                'buttonOptions' => ['class' => 'btn btn-primary'],
                'value' => $model->image,
                'buttonName' => 'Выбрать фотографию'
            ]);
        ?>
        <?= $form->field($model, 'status')->dropDownList(\common\models\City::getStatusList()); ?>
    </div>
    <div class="col col-lg-5">
    <?= $form->field($model, 'meta_title'); ?>
    <?= $form->field($model, 'meta_description'); ?>
    <?= $form->field($model, 'header'); ?>
    <?= $form->field($model, 'bottom_text'); ?>
    <?= $form->field($model, 'resume_meta_title'); ?>
    <?= $form->field($model, 'resume_meta_description'); ?>
    <?= $form->field($model, 'resume_header'); ?>
    <?= $form->field($model, 'resume_bottom_text'); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
