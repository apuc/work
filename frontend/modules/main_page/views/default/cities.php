<?php
/* @var $cities_dnr \common\models\City[] */
/* @var $cities_lug \common\models\City[] */

use common\models\KeyValue;
use common\models\Vacancy;


$this->title = KeyValue::findValueByKey('cities_page_title')?:'Вакансии по городам';
$this->registerMetaTag(['name' => 'description', 'content' => KeyValue::findValueByKey('cities_page_description')?:'Вакансии по городам']);
?>
<main>
    <div class="container">
        <h1 class="cities_main_title"><?=KeyValue::findValueByKey('cities_page_h1')?:'Вакансии по городам'?></h1>
        <img src="images/dotted_line.png" class="title__underline" alt="Пунктирная линия">

        <div class="container__parts">

            <div class="part">
                <p class="region"><a href="/vacancy/dnr">Вакансии ДНР</a> ( Донецкая Народная Республика )</p>
                <div class="cities">

                    <ul>
                        <?php foreach ($cities_dnr as $city): ?>
                        <li>
                            <a class="city" href="<?=Vacancy::getSearchPageUrl(false, $city->slug)?>"><?=$city->name?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                </div>

                <img src="images/dotted_line.png" class="left__underline" alt="Пунктирная линия">

            </div>

            <div class="part">
                <p class="region"><a href="/vacancy/lnr">Вакансии ЛНР</a> ( Луганская Народная Республика )</p>
                <div class="cities">

                    <ul>
                        <?php foreach ($cities_lug as $city): ?>
                            <li><a class="city" href="#"><?=$city->name?></a></li>
                        <?php endforeach; ?>
                    </ul>

                </div>

                <img src="images/dotted_line.png" class="right__underline" alt="Пунктирная линия">

            </div>

        </div>


    </div>


</main>