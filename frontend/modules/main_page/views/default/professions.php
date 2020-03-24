<?php
/* @var $professions \common\models\Professions[] */

use common\models\Vacancy;
?>
<main>
    <div class="container">
        <h1 class="cities_main_title">Профессии</h1>
        <img src="/images/dotted_line.png" class="title__underline" alt="Пунктирная линия">
        <div class="container__parts">
            <div class="part">
                <div class="cities">
                    <ul>
                        <?php
                        $count = count($professions);
                        for ($i=0;$i<$count/2;$i++): ?>
                            <li><a class="city" href="<?=Vacancy::getSearchPageUrl(false, false, $professions[$i]->slug)?>"><?=$professions[$i]->title?></a></li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <img src="/images/dotted_line.png" class="left__underline" alt="Пунктирная линия">
            </div>
            <div class="part">
                <div class="cities">
                    <ul>
                        <?php for ($i=$count/2;$i<$count;$i++): ?>
                            <li><a class="city" href="<?=Vacancy::getSearchPageUrl(false, false, $professions[$i]->slug)?>"><?=$professions[$i]->title?></a></li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <img src="/images/dotted_line.png" class="right__underline" alt="Пунктирная линия">
            </div>
        </div>
    </div>
</main>