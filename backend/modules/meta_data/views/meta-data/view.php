<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MetaData */
if($model->category)
    $this->title = $model->category->name;
if($model->profession)
    $this->title = $model->profession->title;
$this->params['breadcrumbs'][] = ['label' => 'Мета данные', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="meta-data-view">

    <h1><?= Html::encode($this->title.": метаданные") ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Категория',
                'format' => 'html',
                'value' => function($model) {
                    if($model->category)
                        return '<a href="/secure/category/category/view?id='.$model->category->id.'">'.$model->category->name.'</a>';
                    return '';
                },
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'label' => 'Профессия',
                'format' => 'html',
                'value' => function($model) {
                    if($model->profession)
                        return '<a href="/secure/professions/professions/view?id='.$model->profession->id.'">'.$model->profession->title.'</a>';
                    return '';
                },
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            'vacancy_meta_title',
            'vacancy_meta_description:ntext',
            'vacancy_header',
            'vacancy_meta_title_with_city',
            'vacancy_meta_description_with_city:ntext',
            'vacancy_header_with_city',
            'vacancy_bottom_text:ntext',
            'resume_meta_title',
            'resume_meta_description:ntext',
            'resume_header',
            'resume_meta_title_with_city',
            'resume_meta_description_with_city:ntext',
            'resume_header_with_city',
            'resume_bottom_text:ntext',
        ],
    ]) ?>

</div>
