<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\country\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страны';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать страну', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'slug',
            [
                'attribute' => 'meta_title',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'meta_description',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'meta_header',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'search_page_title',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'search_page_header',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'search_page_description',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'main_page_text',
                'format' => 'html',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'main_page_mobile_text',
                'format' => 'html',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'main_page_background_image',
                'format' => ['image',['width'=>'150']],
            ],
            [
                'attribute' => 'main_page_emblem',
                'format' => ['image',['width'=>'150']],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
