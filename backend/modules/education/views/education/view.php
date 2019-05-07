<?php

use common\models\Education;
use common\models\Resume;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Education */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Образование', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="education-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить это образование?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'resume.title',
                'label' => 'Резюме',
                'format' => 'html',
                'value' => function($model)
                {
                    $resume = Resume::findOne($model->resume_id);
                    return '<a href="'.Url::to(['/resume/resume/view', 'id'=>$resume->id]).'">'.$resume->title.'</a>';
                },
            ],
            'name',
            'faculty',
            'year_from',
            'year_to',
            'academic_degree',
            'specialization',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    switch ($model->status){
                        case Education::STATUS_ACTIVE: return 'Активно';
                        case Education::STATUS_INACTIVE: return 'Не активно';
                    }
                    return 'Не активно';
                }
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
