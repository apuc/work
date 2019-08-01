<?php

use yii\helpers\Html;

$this->title = 'Создать город';
$this->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
