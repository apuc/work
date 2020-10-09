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
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <br>
    <?php if($model->category): ?>
        <p>Категория: <a href="/secure/category/category/view?id=<?=$model->category->id?>"><?=$model->category->name?></a></p>
    <?php elseif ($model->profession): ?>
        <p>Профессия: <a href="/secure/professions/professions/view?id=<?=$model->profession->id?>"><?=$model->profession->title?></a></p>
    <?php endif ?>
    <br>
    <div class="col col-lg-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'vacancy_meta_title',
                'vacancy_meta_description:ntext',
                'vacancy_header',
                'vacancy_meta_title_with_city',
                'vacancy_meta_description_with_city:ntext',
                'vacancy_header_with_city',
                'vacancy_bottom_text:ntext',
            ],
        ]) ?>
    </div>
    <div class="col col-lg-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
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

</div>
