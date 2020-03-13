<?php
/* @var $cities \common\models\City[] */
use yii\helpers\ArrayHelper;

?>
<main>
    <div class="container">
        <h1 class="cities_main_title">Вакансии по городам</h1>
        <img src="images/dotted_line.png" class="title__underline" alt="Пунктирная линия">

        <div class="container__parts">

            <div class="part">
                <p class="region">ДНР ( Донецкая Народная Республика )</p>
                <div class="cities">

                    <ul>
                        <?php foreach ($cities_dnr as $city): ?>
                        <li><a class="city" href="<?=\common\models\Vacancy::getSearchPageUrl(false, $city->slug)?>"><?=$city->name?></a></li>
                        <?php endforeach; ?>
                    </ul>

                </div>

                <img src="images/dotted_line.png" class="left__underline" alt="Пунктирная линия">

            </div>

            <div class="part">
                <p class="region">ЛНР ( Луганская Народная Республика )</p>
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