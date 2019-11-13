<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>
<div class="cities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <label class="control-label" for="city-image">Фотография</label>
    <div class="media__upload_img"><img src="<?= $model->image; ?>" width="100px"/></div>
    <?=InputFile::widget([
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
    <?= $form->field($model, 'region_id'); ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\City::getStatusList()); ?>
    <?= $form->field($model, 'longitude'); ?>
    <?= $form->field($model, 'latitude'); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
