<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить мета данные', ['/meta-data/meta-data/update', 'id' => $model->metaData->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'slug',
            [
                'attribute'=>'image',
                'format'=>'html',
                'value' => function($model){
                    return Html::img($model->image, ['height'=>'300px']);
                }
            ],
            [
                'attribute'=>'icon',
                'format'=>'html',
                'value' => function($model){
                    return Html::img($model->icon, ['height'=>'300px']);
                }
            ],
        ],
    ]) ?>

</div>
