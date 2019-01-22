<?php

use common\models\Resume;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Resume */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Резюме', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="resume-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить это резюме?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'employer_id',
                'value' => function ($model) {
                    return $model->employer->second_name . ' ' . $model->employer->first_name . ' ' . $model->employer->patronymic;;
                },
            ],
            'title',
            'description:ntext',
            [
                'attribute' => 'employment_type.name',
                'label' => 'Тип занятости'
            ],
            'schedule_id',
            [
                'label' => 'Умения',
                'value' => function($model){
                    $string = '';
                    $first = true;
                    foreach($model->skill as $skill){
                        if($first){
                            $string .= $skill->name;
                            $first = false;
                        }
                        else
                            $string .= ', ' . $skill->name;
                    }
                    return $string;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    switch ($model->status){
                        case Resume::STATUS_ACTIVE: return 'Активно';
                        case Resume::STATUS_INACTIVE: return 'Не активно';
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
