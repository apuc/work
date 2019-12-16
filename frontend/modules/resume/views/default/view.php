<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Resume */

use common\models\Experience;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = $model->title;
$this->registerMetaTag(['name'=>'description', 'content' => StringHelper::truncate($model->description, 100, '...')]);
$this->registerMetaTag(['name'=>'og:title', 'content' => $model->title]);
$this->registerMetaTag(['name'=>'og:type', 'content' => 'website']);
$this->registerMetaTag(['name'=>'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
$this->registerMetaTag(['name'=>'og:image', 'content' => $model->image_url?:'/images/empty_user.jpg']);
$this->registerMetaTag(['name'=>'og:description', 'content' => StringHelper::truncate($model->description, 100, '...')]);

?>

<div class="resume"><img class="resume__dots2" src="/images/bg-dots.png" alt="" role="presentation"/>
    <div class="resume__circle">
    </div>
    <div class="container container-for-sidebar">
        <div class="resume__left">
            <button class="mobile-contacts jsShowContacts jsShowContactsFlag"><img
                        src="/images/add-contact.svg" alt="" role="presentation"/>
            </button>
            <div class="resume-results">
                <ul class="breadcrumbs">
                    <li><a href="<?=Url::to('/resume/search')?>">К результатам поиска</a>
                    </li>
                    <?php if($model->city):?>
                    <li><a href="<?=Url::to(["/resume/search/$model->city"])?>"><?= $model->city ?></a>
                    </li>
                    <?php endif?>
                    <li><?= $model->title ?></li>
                </ul>
                <div class="resume-results__date">
                    <p>Резюме от
                    </p><span><?= Yii::$app->formatter->asDate($model->update_time, 'dd MM yyyy') ?></span>
                </div>
            </div>
            <section class="resume-top"><img class="resume-top__left" src="<?=$model->image_url?:'/images/empty_user.jpg'?>" alt=""
                                         role="presentation"/>
                <div class="resume-top__right">
<!--                    <div class="resume-top__header">-->
<!--                        <button class="resume-top__download"><img src="/images/resume_download.png" alt=""-->
<!--                                                                  role="presentation"/><span>Скачать<br> резюме</span>-->
<!--                        </button>-->
<!--                        <button class="resume-top__save">Сохранить в отклики-->
<!--                        </button>-->
<!--                        <p class="resume-top__status vr-head">Онлайн-->
<!--                        </p>-->
<!--                    </div>-->
                    <h3 class="resume-top__head"><?= $model->title ?>
                    </h3>
                    <p class="resume-description__text">
                        <?=$model->employer->first_name.' '.$model->employer->second_name?>
                    </p>
                    <span class="resume-top__price">
                        <?php if($model->min_salary>0 && $model->max_salary>0):?>
                            <?= (int)$model->min_salary ?>-<?= (int)$model->max_salary ?> RUB
                        <?php elseif($model->max_salary>0):?>
                            До <?= (int)$model->max_salary ?> RUB
                        <?php elseif($model->min_salary>0):?>
                            От <?= (int)$model->min_salary ?> RUB
                        <?php else:?>
                            По договоренности
                        <?php endif?>
                    </span>
                    <table class="resume-top__text">
                        <tbody>
                        <?php if($model->employer->age>0):?>
                        <tr>
                            <th>Возраст:
                            </th>
                            <td><?= $model->employer->age ?>
                            </td>
                        </tr>
                        <?php endif ?>
                        <?php if($model->employment_type): ?>
                        <tr>
                            <th>Вид занятости:
                            </th>
                            <td><?= $model->employment_type->name ?>
                            </td>
                        </tr>
                        <?php endif ?>
                        <?php if($model->city):?>
                        <tr>
                            <th>Город:
                            </th>
                            <td><?= $model->city ?>
                            </td>
                        </tr>
                        <?php endif?>
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="resume-block single-block-slider">
                <section class="resume-description">
                    <?php if($model->experience):?>
                    <div class="resume-description__item">
                            <div class="resume-description__main-head">
                                <h4 class="resume-description__title-main">Опыт работы</h4>
                                <span class="resume-description__experience"><?= Experience::getPeriod_string(Experience::getPeriod_sum($model->experience)) ?></span>
                            </div>
                            <?php foreach ($model->experience as $experience): ?>
                                <h4 class="resume-description__title-bold"><?= $experience->name ?>
                                </h4>
                                <p class="resume-description__text">
                                    с <?= $experience->month_from >= 10 ? $experience->month_from : ('0' . $experience->month_from) ?>
                                    .<?= $experience->year_from ?>
                                    по
                                    <?= $experience->month_to >= 10 ? $experience->month_to : ('0' . $experience->month_to) ?>
                                    .<?= $experience->year_to ?>
                                    (<?= Experience::getPeriod_string($experience->getPeriod()) ?>)
                                </p>
                                <p class="resume-description__text">
                                    <?= $experience->post ?>
                                </p>
                                <p class="resume-description__text">
                                    <?= $experience->responsibility ?>
                                </p>
                            <?php endforeach; ?>
                    </div>
                    <?php endif?>
                    <?php if($model->education):?>
                        <div class="resume-description__item">
                            <h4 class="resume-description__title-main">Образование
                            </h4>
                            <?php foreach ($model->education as $education): ?>
                                <h4 class="resume-description__title-bold">
                                    <?= $education->name ?>
                                </h4>
                                <p class="resume-description__text"><?= $education->academic_degree ?><?php if($education->year_from || $education->year_to):?>,<?php endif?>
                                    <br>
                                    <?php if($education->year_from):?>
                                    с <?= $education->year_from ?>
                                    <?php endif ?>
                                    <?php if($education->year_to):?>
                                    по
                                    <?= $education->year_to ?>
                                    <?php endif?>
                                    <?php if($education->year_from || $education->year_to):?>
                                    г.
                                    <?php endif?>
                                </p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif ?>
                    <?php if($model->skills):?>
                        <div class="resume-description__item">
                            <h4 class="resume-description__title-main">Профессиональные и другие навыки
                            </h4>
                            <p class="resume-description__text">

                                <?php
                                $i=true;
                                foreach ($model->skills as $skill) {
                                    if($i){
                                        echo $skill->name;
                                        $i=false;
                                    } else {
                                        echo ', '.$skill->name;
                                    }
                                }
                                ?>.
                            </p>
                        </div>
                    <?php endif ?>
                    <?php if($model->description): ?>
                    <div class="resume-description__item">
                        <h4 class="resume-description__title-main">Дополнительная информация
                        </h4>
                        <p class="resume-description__text">
                            <?= nl2br($model->description) ?>
                        </p>
                    </div>
                    <?php endif ?>
                </section>
                <aside class="resume-info jsOpenContacts" id="sidebar-single">
                    <div class="single-vacancy-overlay jsHideContacts"></div>
                    <div class="sidebar-inner">
                        <button class="mobile-contacts sidebar-mobile-contacts jsShowContacts"><img
                                    src="/images/add-contact.svg" alt="" role="presentation"/>
                        </button>
                        <div class="resume-info__head">
                            <h4>Контактная информация
                            </h4>
                            <p>Телефон:
                            </p>
                            <?php if($model->employer->phone): ?>
                                <a href="tel:<?= $model->employer->phone->number ?>"><?= $model->employer->phone->number ?></a>
                            <?php endif ?>
                            <p>Почта:
                            </p><a href="mailto:<?= $model->employer->user->email ?>"><?= $model->employer->user->email ?></a>
                        </div>
                        <div class="resume-info__soc">
                            <?php if ($model->hasSocials()): ?>
                                <p>Написать соискателю в сетях</p>
                                <?php if ($model->vk): ?><a class="vk-bg" target="_blank" href="<?= $model->vk ?>"><img
                                            src="/images/vk.svg" alt="" role="presentation"/></a><?php endif ?>
                                <?php if ($model->facebook): ?><a class="fb-bg" target="_blank" href="<?= $model->facebook ?>"><img
                                            src="/images/fb.svg" alt="" role="presentation"/></a><?php endif ?>
                                <?php if ($model->instagram): ?><a class="fb-bg" target="_blank" href="<?= $model->instagram ?>"><img
                                            src="/images/fb.svg" alt="" role="presentation"/></a><?php endif ?>
                            <?php endif ?>
                        </div>
                        <?php if(!Yii::$app->user->isGuest && $model->owner != Yii::$app->user->id): ?>
                        <button class="resume-info__btn jsSendMessage" data-id="<?=$model->id?>">написать сообщение
                        </button>
                        <?php endif ?>
<!--                        <a class="resume-info__complain" href="#">Пожаловаться на<br>это резюме</a>-->
                    </div>
                </aside>
            </div>
        </div>
<!--        <div class="soc-sidebar" id="sidebar-vr">-->
<!--            <div class="sidebar-inner">-->
<!--                <p class="vr-head">Прямой эфир-->
<!--                </p>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vr-card">-->
<!--                    <div class="vr-card__head">-->
<!--                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""-->
<!--                                                              role="presentation"/>-->
<!--                        </div>-->
<!--                        <div class="vr-card__name-time">-->
<!--                            <p class="vr-card__name">Дмитрий Иванов-->
<!--                            </p><span class="vr-card__time">2 минуты назад</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="vr-card__text">-->
<!--                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили-->
<!--                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69-->
<!--                    </p>-->
<!--                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""-->
<!--                                                            role="presentation"/>Нравится 96</span><span><img-->
<!--                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img-->
<!--                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>