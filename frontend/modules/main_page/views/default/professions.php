<?php
/* @var $professions \common\models\Professions[] */
/* @var $country \common\models\Country */

use common\models\Vacancy;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<main>
    <div class="container">
        <h1 class="cities_main_title">Профессии</h1>
        <form class="search" style="width: 230px" action="<?=Url::toRoute(['/main_page/default/professions'])?>" method="get">
            <?=Html::textInput('search_text', Yii::$app->request->get('search_text')?:'', ['class'=>'home__form-input'])?>
            <?=Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i>', ['class'=>'btn-red'])?>
        </form>
        <img src="/images/dotted_line.png" class="title__underline" alt="Пунктирная линия">
        <div class="container__parts">
            <div class="part">
                <div class="cities">
                    <ul>
                        <?php
                        $count = count($professions);
                        for ($i=0;$i<ceil($count/2);$i++): ?>
                            <li><a class="city" href="<?=Vacancy::getSearchPageUrl(false, false, $professions[$i]->slug, $country?$country->slug:false)?>"><?=$professions[$i]->title?></a></li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <img src="/images/dotted_line.png" class="left__underline" alt="Пунктирная линия">
            </div>
            <div class="part">
                <div class="cities">
                    <ul>
                        <?php for ($i=ceil($count/2);$i<$count;$i++): ?>
                            <li><a class="city" href="<?=Vacancy::getSearchPageUrl(false, false, $professions[$i]->slug, $country?$country->slug:false)?>"><?=$professions[$i]->title?></a></li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <img src="/images/dotted_line.png" class="right__underline" alt="Пунктирная линия">
            </div>
        </div>
    </div>
</main>