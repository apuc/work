<?php

use yii\helpers\Html;
use yii\web\View;

$this->title = 'Добавить письмо';
$this->params['breadcrumbs'][] = ['label' => 'Список писем', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
