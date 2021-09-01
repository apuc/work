<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\logo\models\LogoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логотипы компаний для страницы /employer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Logo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'company_id',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'format'    => 'text',
                'value' => function ($model) {
                    return $model->company ? $model->company->name : 'еще нет';
                },
            ],
            [
                'attribute' => 'image',
                'format'    => 'html',
                'value' => function($model) {
                    return '<img alt="" width="100px" src="'.$model->image.'">';
                },
            ],
            [
                'attribute' => 'active_until',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'format'    => 'text',
                'value' => function ($model) {
                    return date('d-m-y',$model->active_until);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
