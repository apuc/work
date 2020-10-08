<?php

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = 'Изменить новость: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="news-update">

    <?= $this->render('_form', [
        'model' => $model,
        'tags' => $tags,
        'tags_selected' => $tags_selected,
    ]) ?>

</div>
