<?php
/** @var int $index */

/** @var array $categories */
/** @var array $cities */
/** @var \common\models\BannerLocation $model */

?>
<div style="display: flex">
    <div style="width: 45%">
        <?= \kartik\select2\Select2::widget([
            'data' => $categories,
            'model' => $model,
            'attribute' => 'category_id',
            'options' => [
                'placeholder' => 'Начните вводить название категории ...',
                'id' => 'bannerlocation-category-' . $index,
                'name' => "BannerLocation[$index][category_id]"
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>

    <div style="width: 45%">
        <?= \kartik\select2\Select2::widget([
            'data' => $cities,
            'model' => $model,
            'attribute' => 'city_id',
            'options' => [
                'placeholder' => 'Начните вводить название города ...',
                'id' => 'bannerlocation-city-' . $index,
                'name' => "BannerLocation[$index][city_id]"
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>

    <button class="banner-location__delete btn btn-box-tool" style="color: red">X</button>
</div>
