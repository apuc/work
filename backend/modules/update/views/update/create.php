<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Update */

$this->title = 'Создание обновления';
$this->params['breadcrumbs'][] = ['label' => 'Обновления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="update-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
