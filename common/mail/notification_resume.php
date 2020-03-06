<?php
/** @var \common\models\Resume $model */
/** @var \common\models\User $user */
$user = \common\models\User::findOne($model->owner);
?>

Здравствуйте, <?=$user->employer->first_name?>!<br><br>
7 дней назад Вы разместили резюме <a href="<?=Yii::$app->request->hostInfo.'/resume/view'.$model->id?>"><?=$model->title?></a>, Вы еще в поисках работы?<br>
Перейдите в <a href="<?=Yii::$app->request->hostInfo.'/personal-area/all-resume'?>">личный кабинет</a> что бы поднять резюме в поиске и получить больше откликов (это бесплатно).<br>
Если резюме не актуально - отключите его, мы гарантируем посетителям только актуальные резюме на сайте!<br>
Давайте сделаем поиск работы и сотрудников комфортным!<br><br>
Быстрого поиска работы!
