<?php

use common\models\Company;
use common\models\Vacancy;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Banner */

$this->title = "Баннер компании " . $model->company->name;
$this->params['breadcrumbs'][] = ['label' => 'Баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerCssFile('/css/main_style.css');
?>
<div class="vacancy-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить эту вакансию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'logo_url',
                'format'    => 'html',
                'value' => function($model) {
                    return '<img alt="" width="100px" src="'.$model->logo_url.'">';
                },
            ],
            [
                'attribute' => 'image_url',
                'format'    => 'html',
                'value' => function($model) {
                    return '<img alt="" width="100px" src="'.$model->image_url.'">';
                },
            ],
            [
                'attribute' => 'owner',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'format'    => 'text',
                'value' => function ($model) {
                    return $model->ownerUser->username;
                },
            ],
            [
                'attribute' => 'company_id',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'format'    => 'text',
                'value' => function ($model) {
                    return $model->company->name;
                },
            ],
            [
                'attribute' => 'priority',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'created_at',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'value' => function ($model) {
                    return $model->humanCreatedAt;
                }
            ],
            [
                'attribute' => 'updated_at',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'value' => function ($model) {
                    return $model->humanUpdatedAt;
                }
            ],
            [
                'attribute' => 'description',
                'format' => 'text',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'is_active',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'value' => function ($model) {
                    return $model->is_active ? 'Да' : 'Нет';
                }
            ],
            [
                'attribute' => 'Размещения',
                'format' => 'html',
                'value' => function ($model) {
                    $text = '<table class="table table-bordered"><thead><tr><td>Город</td><td>Категория</td></tr></thead>';
                    /** @var \common\models\Banner $model */
                    foreach ($model->bannerLocations as $location) {
                        $text .= '<tr>';
                        $text .= '<td>' . ($location->hasCity ? $location->city->name : '') . '</td>';
                        $text .= '<td>' . ($location->hasCategory ? $location->category->name : '') . '</td>';
                        $text .= '</tr>';
                    }
                    $text .= '</table>';
                    return $text;
                }
            ]
        ],
    ]) ?>
    <h2>Предпросмотр</h2>
    <?=
        \frontend\widgets\Banner::widget([
            'banner' => $model
        ]);
    ?>
</div>
