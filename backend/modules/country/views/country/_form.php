<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'meta_header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'search_page_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'search_page_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'search_page_header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'news_meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'news_meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'news_meta_header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'news_about')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'main_page_text')->widget(CKEditor::className(), [
        'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder', [
            'preset' => 'full',
            'inline' => false,
            'path' => 'frontend/web/media/upload',
        ]),
    ]); ?>

    <?= $form->field($model, 'main_page_mobile_text')->widget(CKEditor::className(), [
        'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder', [
            'preset' => 'full',
            'inline' => false,
            'path' => 'frontend/web/media/upload',
        ]),
    ]); ?>

    <div class="imgUpload">
        <label class="control-label" for="country-main_page_background_image">Фоновое изображение главной страницы</label>
        <div class="media__upload_img"><img src="<?= $model->main_page_background_image; ?>" width="100px"/></div>
        <?php
        echo InputFile::widget([
            'language' => 'ru',
            'controller' => 'elfinder',
            'filter' => 'image',
            'name' => 'Country[main_page_background_image]',
            'id' => 'country-main_page_background_image',
            'template' => '<div class="input-group">{input}<span class="span-btn">{button}</span></div>',
            'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
            'buttonOptions' => ['class' => 'btn btn-primary'],
            'value' => $model->main_page_background_image,
            'buttonName' => 'Выбрать изображение',
        ]);
        ?>
    </div>

    <div class="imgUpload">
        <label class="control-label" for="country-main_page_background_image">Эмблема главной страницы</label>
        <div class="media__upload_img"><img src="<?= $model->main_page_emblem; ?>" width="100px"/></div>
        <?php
        echo InputFile::widget([
            'language' => 'ru',
            'controller' => 'elfinder',
            'filter' => 'image',
            'name' => 'Country[main_page_emblem]',
            'id' => 'country-main_page_emblem',
            'template' => '<div class="input-group">{input}<span class="span-btn">{button}</span></div>',
            'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
            'buttonOptions' => ['class' => 'btn btn-primary'],
            'value' => $model->main_page_emblem,
            'buttonName' => 'Выбрать изображение',
        ]);
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
