<?php
/* @var $cities_dnr \common\models\City[] */
/* @var $cities_lug \common\models\City[] */

use common\models\Vacancy;

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
                        <li>
                            <a class="city" href="<?=Vacancy::getSearchPageUrl(false, $city->slug)?>"><?=$city->name?></a>
                            <a class="city" href="<?=Vacancy::getSearchPageUrl(false, $city->slug)?>">
                                <svg class="bi bi-briefcase-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M0 12.5A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5V6.85L8.129 8.947a.5.5 0 01-.258 0L0 6.85v5.65z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M0 4.5A1.5 1.5 0 011.5 3h13A1.5 1.5 0 0116 4.5v1.384l-7.614 2.03a1.5 1.5 0 01-.772 0L0 5.884V4.5zm5-2A1.5 1.5 0 016.5 1h3A1.5 1.5 0 0111 2.5V3h-1v-.5a.5.5 0 00-.5-.5h-3a.5.5 0 00-.5.5V3H5v-.5z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <a class="city" href="<?=Vacancy::getSearchPageUrl(false, $city->slug)?>">
                                <i class="fa fa-briefcase"></i>
                            </a>
                        </li>
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