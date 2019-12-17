<?php

use common\models\Company;
use common\models\Vacancy;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */

$this->title = $model->post;
$this->params['breadcrumbs'][] = ['label' => 'Вакансии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->post;
\yii\web\YiiAsset::register($this);
?>
<div class="vacancy-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить эту вакансию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Работодатель',
                'format' => 'html',
                'value' => function($model)
                {
                    $company=Company::findOne($model->company_id);
                    return '<a href="'.\yii\helpers\Url::to(['/company/company/view', 'id' => $company->id]).'">'.$company->name.'</a>';
                },
            ],
            'post',
            'responsibilities:ntext',
            'employment_type.name',
            'min_salary',
            'max_salary',
            'qualification_requirements',
            'work_experience',
            'education',
            [
                'label' => 'Категории',
                'format' => 'html',
                'value' => function($model) {
                    $result='';
                    foreach ($model->category as $category)
                        $result.=$category->name.'<br>';
                    return $result;
                }
            ],
            'working_conditions',
            'video',
            'address',
            'home_number',
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
                        case Vacancy::STATUS_ACTIVE: return 'Активна';
                        case Vacancy::STATUS_INACTIVE: return 'Не активна';
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
            [
                'attribute' => 'countViews',
                'label' => 'Просмотры'
            ],
        ],
    ]) ?>

</div>
