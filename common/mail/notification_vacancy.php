<?php
/** @var \common\models\Vacancy $model */
/** @var \common\models\User $user */
$user = \common\models\User::findOne($model->owner);
?>

Здравствуйте, <?=$user->employer->first_name?>!<br><br>
7 дней назад Вы разместили вакансию <a href="<?=Yii::$app->request->hostInfo.'/vacancy/view'.$model->id?>"><?=$model->post?></a>, Вы еще в поисках сотруднкиа?<br>
Перейдите в <a href="<?=Yii::$app->request->hostInfo.'/personal-area/all-vacancy'?>">личный кабинет</a> что бы поднять вакансию в поиске и получить больше откликов (это бесплатно).<br>
Если вакансия не актуальна - отключите её, мы гарантируем посетителям только актуальные вакансии на сайте!<br>
Давайте сделаем поиск работы и сотрудников комфортным!<br><br>
Быстрого закрытия вакансий и хорошего персонала!
