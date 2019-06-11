<?php

/* @var $this yii\web\View */
/* @var $vacancy common\models\Vacancy */
/* @var $resume common\models\Resume */
/* @var $text string */

use yii\helpers\Url; ?>
Пользователь <?=$resume->employer->second_name?> <?=$resume->employer->first_name?> заинтересовался вашей вакансией <?=$vacancy->post?><br>
и прилагает своё резюме <a href="<?=Url::base(true).Url::toRoute(['/resume/default/view', 'id'=>$resume->id])?>"><?=$resume->title?></a><br>
<?=$text?>
