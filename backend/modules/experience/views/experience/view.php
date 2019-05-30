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
            'post',
            'responsibility',
            [
                'attribute' => 'month_from',
                'value' => function ($model) {
                    /** @var Experience $model */
                    if($model->month_from>0&&$model->month_from<13)
                        return Experience::$months[$model->month_from];
                    return null;
                }
            ],
            'year_from',
            [
                'attribute' => 'month_to',
                'value' => function ($model) {
                    /** @var Experience $model */
                    if($model->month_to>0&&$model->month_to<13)
                        return Experience::$months[$model->month_to];
                    return null;
                }
            ],
            'year_to',
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
