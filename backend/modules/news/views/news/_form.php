<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['rows' => 6]) ?>
    <?= $form->field($model, 'description')->textInput(['rows' => 6]) ?>
    <?= $form->field($model, 'country_id')->dropDownList((new \common\models\News())->getCountry1()); ?>
    <?= $form->field($model, 'meta_title')->textInput(['rows' => 6]) ?>
    <?= $form->field($model, 'meta_description')->textInput(['rows' => 6]) ?>
    <?= $form->field($model, 'meta_header')->textInput(['rows' => 6]) ?>
    <?/*= $form->field($model, 'slug')->textInput(['rows' => 6]) */?>


    <?php echo $form->field($model, 'content')->widget(CKEditor::className(), [
        'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder', [
            'preset' => 'full',
            'inline' => false,
            'path' => 'frontend/web/media/upload',
        ]),
    ]); ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\News::getStatusList()) ?>

    <?php
    echo '<label> Выберите дату публикации</label>';
    echo '<br>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'dt_public',
        'language' => 'ru',
    ]);
    ?>
    <div class="imgUpload">
        <div class="media__upload_img"><img src="<?= $model->img; ?>" width="100px"/></div>
        <?php
        echo InputFile::widget([
            'language' => 'ru',
            'controller' => 'elfinder',
            // вставляем название контроллера, по умолчанию равен elfinder
            'filter' => 'image',
            // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
            'name' => 'News[img]',
            'id' => 'news-img',
            'template' => '<div class="input-group">{input}<span class="span-btn">{button}</span></div>',
            'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
            'buttonOptions' => ['class' => 'btn btn-primary'],
            'value' => $model->img,
            'buttonName' => 'Выбрать изображение',
        ]);
        ?>
    </div>
</div>
<label class="control-label" for="company-city_id">Начните вводить теги</label>
<?= Select2::widget([
    'name' => 'Tags',
    'data' => ArrayHelper::map($tags, 'id', 'tag'),
    'value' => $tags_selected,
    'options' => ['placeholder' => 'Начните вводить теги ...', 'multiple' => true],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>


<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
