<?php

use yii\helpers\Html;

?>
<?=Html::beginForm();?>
Название класса
<?=Html::textInput('class_name');?>
</br>
</br>
id модели
<?=Html::textInput('model_id');?>
</br>
</br>
Url, куда отправится запрос
<?=Html::textInput('url');?>
</br>
</br>
Связанные сущности(перечислять через запятую)
<?=Html::textInput('relations');?>
</br>
</br>
Аттрибуты(перечислять через запятую)
<?=Html::textInput('attributes');?>
</br>
</br>
<?=Html::submitButton('Отправить')?>
<?=Html::endForm()?>
