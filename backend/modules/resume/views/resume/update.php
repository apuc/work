<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Resume */

$this->title = 'Изменить резюме: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Резюме', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="resume-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
