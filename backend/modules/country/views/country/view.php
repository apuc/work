<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Country */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="country-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <div class="col col-lg-4">
        <h3>Основная информация</h3>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'slug',
            ],
        ]) ?>
        <h3>Мета данные страницы поиска</h3>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'search_page_title',
                'search_page_header',
                'search_page_description',
            ],
        ]) ?>
        <h3>Мета данные страницы новостей</h3>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'news_meta_title',
                'news_meta_description',
                'news_meta_header',
                'news_about',
            ],
        ]) ?>
    </div>
    <div class="col col-lg-5">
        <h3>Мета данные главной страницы</h3>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'meta_title',
                'meta_description:ntext',
                'meta_header',
                [
                    'attribute' => 'main_page_text',
                    'format' => 'html'
                ],
                [
                    'attribute' => 'main_page_mobile_text',
                    'format' => 'html'
                ],
                [
                    'attribute' => 'main_page_background_image',
                    'format' => ['image',['width'=>'100','height'=>'100']],
                ],
                [
                    'attribute' => 'main_page_emblem',
                    'format' => ['image',['height'=>'200']],
                ],
            ],
        ]) ?>
    </div>

</div>
