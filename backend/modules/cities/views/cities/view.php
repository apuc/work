<?php

/* @var $this yii\web\View */
/* @var $model \common\models\City */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="cities-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Скрыть', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите скрыть этот город?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="col col-lg-5">
        <legend>Основные данные</legend>
        <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'prepositional',
                    [
                        'attribute' => 'region.name',
                        'label' => 'Область'
                    ],
                    'slug',
                    [
                        'attribute'=>'image',
                        'format'=>'html',
                        'value' => function($model){
                            return Html::img($model->image, ['max-height'=>'300px']);
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return \common\models\City::getStatusName($model->status);
                        }
                    ],
                ],
            ])
        ?>
    </div>

    <div class="col col-lg-5">
        <legend>Мета данные</legend>
        <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'meta_title',
                    'meta_description',
                    'header',
                    'bottom_text',
                    'resume_meta_title',
                    'resume_meta_description',
                    'resume_header',
                    'resume_bottom_text',
                ],
            ])
        ?>
    </div>

</div>