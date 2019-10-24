<?php

use yii\helpers\Html;

?>
<?=Html::beginForm();?>
Название класса
<?=Html::textInput('class_name', isset($post['class_name'])?$post['class_name']:'');?>
</br>
</br>
id модели
<?=Html::textInput('model_id', isset($post['model_id'])?$post['model_id']:'');?>
</br>
</br>
Url, куда отправится запрос
<?=Html::textInput('url', isset($post['url'])?$post['url']:'');?>
</br>
</br>
Связанные сущности(перечислять через запятую)
<?=Html::textInput('relations', isset($post['relations'])?$post['relations']:'');?>
</br>
</br>
Аттрибуты(перечислять через запятую)
<?=Html::textInput('attributes', isset($post['attributes'])?$post['attributes']:'');?>
</br>
</br>
<?=Html::submitButton('Отправить')?>
<?=Html::endForm()?>
<pre>
<?php if($request !== null) print_r(json_encode($request))?>
</pre>
<pre>
<?php print_r($request)?>
</pre>
<pre>
<?php print_r($response)?>
</pre>
