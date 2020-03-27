<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\professions\models\Professions */

$this->title = 'Изменить профессию: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Профессии', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="professions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
