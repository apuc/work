<?php


/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = 'Создать новость';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <?= $this->render('_form', [
        'model' => $model,
        'tags' => $tags,
        'tags_selected' => $tags_selected,
    ]) ?>

</div>
