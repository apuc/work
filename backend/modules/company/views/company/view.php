<?php

use common\models\Company;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Company */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Работодатели', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="company-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить этого работодателя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user.username',
                'label' => 'Пользователь'
            ],
            [
                'attribute' => 'image_url',
                'format'    => 'html',
                'value' => function($model)
                {
                    return '<img width="300px" src="'.$model->image_url.'">';
                },
            ],
            'name',
            'website',
            'activity_field',
            'vk',
            'facebook',
            'instagram',
            'skype',
            'description',
            'contact_person',
            'phone.number',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    switch ($model->status){
                        case Company::STATUS_ACTIVE: return 'Активен';
                        case Company::STATUS_INACTIVE: return 'Не активен';
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
