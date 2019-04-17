<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Resume */

$this->title = $model->title;

use common\models\Experience; ?>


<section class="resume"><img class="resume__dots2" src="/images/bg-dots.png" alt="" role="presentation"/>
    <div class="resume__circle">
    </div>
    <div class="container container-for-sidebar">
        <div class="resume__left">
            <button class="mobile-contacts jsShowContacts jsShowContactsFlag"><img
                        src="/images/add-contact.svg" alt="" role="presentation"/>
            </button>
            <div class="resume-results">
                <ul class="breadcrumbs">
                    <li><a href="#">К результатам поиска</a>
                    </li>
                    <li><a href="#"><?= $model->city ?></a>
                    </li>
                    <li><?= $model->title ?></li>
                </ul>
                <div class="resume-results__date">
                    <p>Резюме от
                    </p><span><?= Yii::$app->formatter->asDate($model->created_at, 'dd MM yyyy') ?></span>
                </div>
            </div>
            <div class="resume-top"><img class="resume-top__left" src="/images/resume_image_1.png" alt=""
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
                    </h3><span class="resume-top__price"><?= $model->min_salary ?>-<?= $model->max_salary ?> RUB</span>
                    <table class="resume-top__text">
                        <tbody>
                        <tr>
                            <th>Занятость:
                            </th>
                            <td><?= $model->employment_type->name ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Возраст:
                            </th>
                            <td><?= $model->employer->age ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Город:
                            </th>
                            <td><?= $model->city ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="resume-block single-block-slider">
                <div class="resume-description">
                    <div class="resume-description__item">
                        <div class="resume-description__main-head">
                            <h4 class="resume-description__title-main">Опыт работы
                            </h4><span
                                    class="resume-description__experience"><?= Experience::getPeriod_string(Experience::getPeriod_sum($model->experience)) ?></span>
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
                                <?= $experience->responsibility ?>
                            </p>
                        <?php endforeach; ?>
                    </div>
                    <div class="resume-description__item">
                        <h4 class="resume-description__title-main">Образование
                        </h4>
                        <?php foreach ($model->education as $education): ?>
                            <h4 class="resume-description__title-bold">
                                <?= $education->name ?>
                            </h4>
                            <p class="resume-description__text">Горловка <br><?= $education->academic_degree ?>,
                                <br>с <?= $education->year_from ?> по
                                <?= $education->year_to ?>г.
                            </p>
                        <?php endforeach; ?>
                    </div>
                    <div class="resume-description__item">
                        <h4 class="resume-description__title-main">Профессиональные и другие навык
                        </h4>
                        <h4 class="resume-description__title-bold">Навыки работы с компьютером
                        </h4>
                        <p class="resume-description__text">Отличное знаение и владение 1С 8, 1 С ЗУП, Программы
                            Клиент- банк, MEDoc,MS Office, e-mail Востановление данных после двух вирусов.
                        </p>
                        <h4 class="resume-description__title-bold resume-description__title-bold_mb">Relationship
                            building, Goal setting, Business communication
                        </h4>
                        <p class="resume-description__text resume-description__text_mb">(15 лет опыта)
                        </p>
                        <p class="resume-description__text">Свободно, использую в настоящее время.
                        </p>
                        <h4 class="resume-description__title-bold resume-description__title-bold_mb">International
                            contracts, International logistics
                        </h4>
                        <p class="resume-description__text resume-description__text_mb">(15 лет опыта)
                        </p>
                        <p class="resume-description__text">Свободно, использую в настоящее время.
                        </p>
                    </div>
                    <div class="resume-description__item">
                        <h4 class="resume-description__title-main">Дополнительная информация
                        </h4>
                        <p class="resume-description__text">
                            <?= $model->description ?>
                        </p>
                    </div>
                </div>
                <div class="resume-info jsOpenContacts" id="sidebar-single">
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
                            <?php foreach ($model->employer->phone as $phone): ?>
                                <a href="tel:<?= $phone->number ?>"><?= $phone->number ?></a>
                            <?php endforeach ?>
                            <p>Почта:
                            </p><a href="mailto:<?= $model->employer->email ?>"><?= $model->employer->email ?></a>
                        </div>
                        <div class="resume-info__soc">
                            <?php if ($model->hasSocials()): ?>
                                <p>Написать соискателю в сетях</p>
                                <?php if ($model->vk): ?><a class="vk-bg" href="<?= $model->vk ?>"><img
                                            src="/images/vk.svg" alt="" role="presentation"/></a><?php endif ?>
                                <?php if ($model->facebook): ?><a class="fb-bg" href="<?= $model->facebook ?>"><img
                                            src="/images/fb.svg" alt="" role="presentation"/></a><?php endif ?>
                                <?php if ($model->instagram): ?><a class="fb-bg" href="<?= $model->instagram ?>"><img
                                            src="/images/fb.svg" alt="" role="presentation"/></a><?php endif ?>
                            <?php endif ?>
                        </div>
                        <button class="resume-info__btn">написать сообщение
                        </button>
                        <a class="resume-info__complain" href="#">Пожаловаться на<br>это резюме</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="soc-sidebar" id="sidebar-vr">
            <div class="sidebar-inner">
                <p class="vr-head">Прямой эфир
                </p>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
                <div class="vr-card">
                    <div class="vr-card__head">
                        <div class="vr-card__head-image"><img src="/images/vr_card_image.png" alt=""
                                                              role="presentation"/>
                        </div>
                        <div class="vr-card__name-time">
                            <p class="vr-card__name">Дмитрий Иванов
                            </p><span class="vr-card__time">2 минуты назад</span>
                        </div>
                    </div>
                    <p class="vr-card__text">
                        Ресторану-пивоварне «Beerstown” требуются официанты. Проживание желательно в Будённовскомили
                        Пролетарском р-не г.Донецка. Все вопросы по телефону: 071-310-69-69
                    </p>
                    <div class="vr-card__bottom"><span><img src="/images/like.svg" alt=""
                                                            role="presentation"/>Нравится 96</span><span><img
                                    src="/images/chat.svg" alt="" role="presentation"/>Комментировать 5</span><span><img
                                    src="/images/speaker-side-view.svg" alt="" role="presentation"/>4</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>