<?php

use common\models\Company;
use kartik\select2\Select2;
use mihaildev\elfinder\InputFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

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

    <?=InputFile::widget([
        'language' => 'ru',
        'controller' => 'elfinder',
        // вставляем название контроллера, по умолчанию равен elfinder
        'filter' => 'image',
        // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
        'name' => 'Company[image_url]',
        'id' => 'company-image_url',
        'template' => '<div class="input-group">{input}<span class="span-btn">{button}</span></div>',
        'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
        'buttonOptions' => ['class' => 'btn btn-primary'],
        'value' => $model->image_url,
        'buttonName' => 'Выбрать фотографию',
    ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activity_field')->textarea() ?>

    <?= $form->field($model, 'vk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instagram')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textArea() ?>

    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>

    <label class="control-label" for="company-contact_person">Номер телефона</label>
    <?=Html::textInput('phone_number', $model->phone?$model->phone->number:null, ['class'=>'form-control'])?>

    <?=$form->field($model, 'is_trusted')->checkbox()?>
    <?= $form->field($model, 'status')->dropDownList([
        Company::STATUS_ACTIVE => 'Активен',
        Company::STATUS_INACTIVE => 'Не активен',
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
