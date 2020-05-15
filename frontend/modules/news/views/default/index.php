<?php
/** @var News[] $news */
/** @var  array[] $model */
/** @var  array[] $model1 */


use common\models\News;
use yii\helpers\Url;

if ($model){
    $model = '<li>' . $model .'</li>';
    $this->title = $model1->news_meta_title;
    $this->registerMetaTag(['name' => 'description', 'content' => $model1->news_meta_description]);
    $about = $model1->news_about;
    $newsH1 = $model1->news_meta_header;
}else{
    $model = '';
    $this->title = \common\models\KeyValue::findValueByKey('news_meta_title');
    $this->registerMetaTag(['name' => 'description', 'content' => \common\models\KeyValue::findValueByKey('news_meta_description')]);
    $about = \common\models\KeyValue::findValueByKey('news_about');
    $newsH1 = \common\models\KeyValue::findValueByKey('news_meta_header');
}

?>
<section class="news">
    <img class="single-vacancy__dots2" src="/images/bg-dots.png" alt="точки" role="presentation">
    <div class="single-vacancy__circle"></div>
    <div class="container">
        <div class="resume-results">
            <ul class="breadcrumbs">
                <li>
                    <a href="<?=Url::to('/')?>">Главная</a>
                </li>
                <li>
                    <a href="<?=Url::to('/news/')?>">Новости</a>
                </li>
                    <?=$model?>
            </ul>
        </div>
        <div class="news-header">
            <h1><?=$newsH1?></h1>
        </div>
        <div class="single-block single-block-slider">
            <div class="single-block__left news-items news-items-img">
                <?php foreach ($news as $new):?>
                <div class="news-item">
                    <h2><?=$new->title?></h2>
                    <div class="news-items-img__block">
                        <img src="<?=$new->img?>" alt="">
                        <div>
                            <p class="red-line">
                                <?=$new->description?>
                            </p>
                            <a href="<?=Url::to(['/news/'.$new->slug])?>">Читать полностью</a>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <aside class="single-block__right sidebar-single jsOpenContacts" id="sidebar-single">
                <div class="sidebar-inner news-block">
                   <!-- <div class="sr-block news-sr-block">
                        <span class="image-rabota">Работа Донецк</span>
                        <div class="d-flex flex-column ml15">
                            <p>Работа в Донецке</p>
                            <a href="/" target="_blank">https://rabota.today</a>
                        </div>
                    </div>-->
                   <!-- <div class="resume-info__soc justify-center">
                        <p>Написать компании в сетях</p>
                        <a class="vk-bg" rel="nofollow" target="_blank" href="https://vk.com/write-80799057">
                            <img src="/images/vk.svg" alt="Иконка VK" role="presentation"/>
                        </a>-->
<!--                        <a class="fb-bg" rel="nofollow" target="_blank" href="#">-->
<!--                            <img src="/images/fb.svg" alt="Иконка facebook" role="presentation"/>-->
<!--                        </a>-->
<!--                        <a class="inst-bg" rel="nofollow" target="_blank" href="#">-->
<!--                            <img src="/images/instagram.svg" alt="Иконка instagram" role="presentation"/>-->
<!--                        </a>-->
                   <!-- </div>-->
                    <div class="sr-btn">
                        <a href="https://vk.com/write-80799057"><button class="sr-btn__btn btn btn-red">Задать свой вопрос</button></a>
                        <p class="sr-btn__text">Для срочных вопросов и предложений</p>
                    </div>
                    <div class="last-vacancy pc-last-vacancy">
                        <p class="last-vacancy__head">Немного о сайте</p>
                        <div class="last-vacancy__item">
                            <div class="last-vacancy__info">
                                <p>
                                    <?=$about?>
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