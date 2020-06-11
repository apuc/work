<?php
/** @var \common\models\Banner $model */
?>

<div class="banner-advertising">
    <img src="<?= $model->image_url ?>" alt="">
    <div class="banner-advertising__right">
        <h3>Самые актуальные вакансии фирменных магазинов и гипермаркетов “МОЛОКО”</h3>
        <div class="banner-advertising__right-bottom">
            <img src="<?= $model->logo_url ?>" alt="">
            <a href="<?= \yii\helpers\Url::toRoute(['/company/default/view', 'id' => $model->company_id]) ?>" class="btn-card btn-red">
                Посмотреть полностью
            </a>
        </div>
    </div>
</div>
