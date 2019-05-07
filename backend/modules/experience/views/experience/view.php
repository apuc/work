<?php

use common\models\Experience;
use common\models\Resume;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Experience */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Опыт', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="experience-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить этот опыт?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Резюме',
                'format'    => 'html',
                'value' => function($model)
                {
                    $resume = Resume::findOne($model->resume_id);
                    return '<a href="'.\yii\helpers\Url::to(['/resume/resume/view', 'id' => $resume->id]).'">'.$resume->title.'</a>';
                },
            ],
            'name',
            'city',
            'post',
            'responsibility',
            'month_from',
            'year_from',
            'month_to',
            'year_to',
            'department',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    switch ($model->status){
                        case Experience::STATUS_ACTIVE: return 'Активно';
                        case Experience::STATUS_INACTIVE: return 'Не активно';
                    }
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    $d = new DateTime();
                    $d->setTimestamp($model->created_at);
                    return $d->format('d-m-Y G:i:s');
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    $d = new DateTime();
                    $d->setTimestamp($model->updated_at);
                    return $d->format('d-m-Y G:i:s');
                },
            ],
        ],
    ]) ?>

</div>
