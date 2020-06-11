<?php

use common\models\City;
use mihaildev\elfinder\InputFile;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Company;

/* @var $this yii\web\View */
/* @var $model common\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vacancy-form">

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
        'name' => 'Banner[image_url]',
        'id' => 'banner-image_url',
        'template' => '<div class="input-group">{input}<span class="span-btn">{button}</span></div>',
        'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
        'buttonOptions' => ['class' => 'btn btn-primary'],
        'value' => $model->image_url,
        'buttonName' => 'Выбрать фотографию',
    ]);
    ?>


    <?=InputFile::widget([
        'language' => 'ru',
        'controller' => 'elfinder',
        'filter' => 'image',
        'name' => 'Banner[logo_url]',
        'id' => 'banner-logo_url',
        'template' => '<div class="input-group">{input}<span class="span-btn">{button}</span></div>',
        'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
        'buttonOptions' => ['class' => 'btn btn-primary'],
        'value' => $model->logo_url,
        'buttonName' => 'Выбрать логотип',
    ]);
    ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?= $form->field($model, 'is_active')->checkbox(); ?>

    <?= $form->field($model, 'priority')->textInput(); ?>

    <div id="banner-locations" data-banner-id="<?= $model->id ?>">
    <?php
        $categories = \common\models\Category::find()->all();
        $cities = City::find()->all();
        foreach($model->bannerLocations as $key => $bannerLocation): ?>
        <div style="display: flex">
            <div style="width: 45%">

                <?= $form->field($bannerLocation, 'category_id')->widget(Select2::className(),
                    [
                        'data' => ArrayHelper::map($categories, 'id', 'name'),
                        'options' => [
                            'placeholder' => 'Начните вводить название категории ...',
                            'id' => 'bannerlocation-category-' . $key,
                            'name' => "BannerLocation[$key][category_id]"
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]
                ); ?>
            </div>

            <div style="width: 45%">
                <?= $form->field($bannerLocation, 'city_id')->widget(Select2::className(),
                    [
                        'data' => ArrayHelper::map($cities, 'id', 'name'),
                        'options' => [
                            'placeholder' => 'Начните вводить название города ...',
                            'id' => 'bannerlocation-city-' . $key,
                            'name' => "BannerLocation[$key][city_id]"
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]
                ); ?>
            </div>

            <button class="banner-location__delete btn btn-box-tool" style="color: red">X</button>


        </div>
        <?php endforeach; ?>
        </div>
    <button class="btn btn-success js-add-location">Добавить расположение</button>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS

    let _bannerLocationIndex = 99999;
    let bannerLocations = $('#banner-locations');
    bannerLocations.on('click', '.banner-location__delete', function() {
      $(this).parent().remove();
    });
    
    $('.js-add-location').on('click', function(e) {
      e.preventDefault();
      
      _bannerLocationIndex--;
      $.get('/secure/banner/banner/banner-location-select', {index: _bannerLocationIndex}, function (data) {
        bannerLocations.append(data);
      });
    })
JS;
$this->registerJs($js);
?>