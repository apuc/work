<?php

/* @var $this yii\web\View */
/* @var $vacancy common\models\Vacancy */
/* @var $resume common\models\Resume */
/* @var $text string */

use yii\helpers\Url; ?>
Компания <?=$vacancy->company->name?> заинтересовалась вашим резюме <?=$resume->title?><br>
и готова предложить вам вакансию <a href="<?=Url::base(true).Url::toRoute(['/vacancy/default/view', 'id'=>$vacancy->id])?>"><?=$vacancy->post?></a><br>
<?=$text?>
