<?php
/** @var News[] $news */

use common\models\News;
use yii\helpers\Url;

$this->title = 'Новости';
?>
<section class="news">
    <img class="single-vacancy__dots2" src="/images/bg-dots.png" alt="точки" role="presentation">
    <div class="single-vacancy__circle"></div>
    <div class="container">
        <div class="resume-results">
            <!--<ul class="breadcrumbs">
                <li>
                    <a href="#">Результаты поиска</a>
                </li>
                <li>
                    <a href="#">Помощь</a>
                </li>
                <li>База знаний</li>
            </ul>-->
        </div>

        <div class="single-block single-block-slider">
            <div class="single-block__left news-items news-items-img">
                <?php foreach ($news as $new):?>
                <div class="news-item">
                    <h2><?=$new->title?></h2>
                    <div class="news-items-img__block">
                        <img src="<?= $new->img ?>" style="width: 175px;" alt="">
                        <div>
                            <p class="red-line">
                                <?=$new->description?>
                            </p>
                            <a href="<?=Url::to(['/news/default/view', 'id'=>$new->id])?>">Читать полностью</a>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <aside class="single-block__right sidebar-single jsOpenContacts" id="sidebar-single">
                <div class="sidebar-inner news-block">
                    <div class="sr-block news-sr-block">
                        <span class="image-rabota">Работа Донецк</span>
                        <div class="d-flex flex-column ml15">
                            <p>Работа в Донецке</p>
                            <a href="https://vk.com/rabotad0netsk" target="_blank">https://rabota.today</a>
                        </div>
                    </div>
                    <div class="resume-info__soc justify-center">
                        <p>Написать компании в сетях</p>
                        <a class="vk-bg" rel="nofollow" target="_blank" href="https://vk.com/rabotad0netsk">
                            <img src="/images/vk.svg" alt="Иконка VK" role="presentation"/>
                        </a>
<!--                        <a class="fb-bg" rel="nofollow" target="_blank" href="#">-->
<!--                            <img src="/images/fb.svg" alt="Иконка facebook" role="presentation"/>-->
<!--                        </a>-->
<!--                        <a class="inst-bg" rel="nofollow" target="_blank" href="#">-->
<!--                            <img src="/images/instagram.svg" alt="Иконка instagram" role="presentation"/>-->
<!--                        </a>-->
                    </div>
                    <!--<div class="sr-btn">
                        <button class="sr-btn__btn btn btn-red">Задать свой вопрос</button>
                        <p class="sr-btn__text">Для срочных вопросов и предлодений</p>
                    </div>-->
                    <div class="last-vacancy pc-last-vacancy">
                        <p class="last-vacancy__head">Немного о сайте</p>
                        <div class="last-vacancy__item">
                            <div class="last-vacancy__info">
                                <p>
                                    Полезная информация для всех, кто занят поиском или предоставляет работу в ДНР.
                                </p>
                                <p>
                                    Появилась новая, а главное – абсолютно бесплатная и удобная, интернет-площадка для
                                    поиска работы и набора сотрудников в ДНР с простым и понятным функционалом.
                                </p>
                                <p>
                                    Ее основная цель – подставить надежное плече помощи всем работодателям и соискателям
                                    Республики. Первые могут разместить вакансии, после чего регулярно просматривать
                                    статистику просмотров и ответы на опубликованные заявки. А вторые – выложить резюме,
                                    которое смогут просмотреть все работодатели ДНР.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <div class="last-vacancy mob-last-vacancy news-block">
                <p class="last-vacancy__head">Немного о сайте</p>
                <div class="last-vacancy__item">
                    <div class="last-vacancy__info">
                        <p>
                            Полезная информация для всех, кто занят поиском или предоставляет работу в ДНР.
                        </p>
                        <p>
                            Появилась новая, а главное – абсолютно бесплатная и удобная, интернет-площадка для
                            поиска работы и набора сотрудников в ДНР с простым и понятным функционалом.
                        </p>
                        <p>
                            Ее основная цель – подставить надежное плече помощи всем работодателям и соискателям
                            Республики. Первые могут разместить вакансии, после чего регулярно просматривать
                            статистику просмотров и ответы на опубликованные заявки. А вторые – выложить резюме,
                            которое смогут просмотреть все работодатели ДНР.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>