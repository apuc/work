<?php
/** @var News $model */
/** @var News $random */

use common\models\News;
use yii\helpers\Url;
use yii2mod\comments\widgets\Comment;

$this->title = $model->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $model->meta_description]);

?>
<style>
    .title-block .h3-body-title {
        float: unset;
    }
</style>
<section class="news-view">
    <img class="single-vacancy__dots2" src="/images/bg-dots.png" alt="точки" role="presentation">
    <div class="single-vacancy__circle"></div>
    <div class="container">
        <div class="resume-results">
            <ul class="breadcrumbs">
                <li>
                    <a href="<?=Url::to('/')?>">Главная</a>
                </li>
                <li>
                    <a href="<?=Url::to('/news/')?>">Все новости</a>
                </li>
                <li>
                    <a href="<?=Url::to('/news/' . $model->country->slug)?>"><?=$model->country->name?></a>
                </li>
                <li>
                  <p>&nbsp;-&nbsp;</p>
                </li>
                <!--<li>
                    <a href="#">Помощь</a>
                </li>-->
                <li>
                    <?=$model->title?>
                </li>
            </ul>
        </div>
        <div class="news-view__block">
            <h2><?=$model->title?></h2>
            <div class="news-view__block-text">
                <?=$model->content?>
            </div>
        </div>
        <div class="news-view__interesting">
            <h2>Вам может быть интересно</h2>
            <div class="news-view__interesting-block">
                <div class="news-item">
                    <h2><?=$random->title?></h2>
                    <div class="news-items-img__block">
                        <img src="<?=$random->img?>" style="width: 250px;" alt="">
                        <div>
                            <p class="red-line">
                                <?=$random->description?>
                            </p>
                            <a href="<?=Url::to(['/news/'.$random->slug])?>">Читать полностью</a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-inner news-block">
                    <!--<div class="sr-block news-sr-block">
                        <span class="image-rabota">Работа Донецк</span>
                        <div class="d-flex flex-column ml15">
                            <p>Работа в Донецке</p>
                            <a href="https://vk.com/rabotad0netsk" target="_blank">https://rabota.today</a>
                        </div>
                    </div>-->
                    <!--<div class="resume-info__soc justify-center">
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
                    <!--</div>-->
                </div>
            </div>
        </div>
        <div class="comment-container" style="">
        <?= Comment::widget([
            'model' => $model,
        ]); ?>
        </div>
    </div>
</section>