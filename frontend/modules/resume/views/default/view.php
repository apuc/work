<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Resume */

/* @var $referer_category \common\models\Category */

use common\classes\MoneyFormat;
use common\models\City;
use common\models\Experience;
use common\models\Resume;
use yii\helpers\StringHelper;
use yii\helpers\Url;
if (!Experience::getPeriod_string(Experience::getPeriod_sum($model->experience)) == 0){
    $exp = Experience::getPeriod_string(Experience::getPeriod_sum($model->experience));
}else{
    $exp = 'без опыта';
}

$this->title = 'Резюме' . ':' . $model->employer->second_name . ' ' . $model->employer->first_name . '- ' . $model->title . ',' . $model->city0->name;
//$this->registerMetaTag(['name'=>'description', 'content' => StringHelper::truncate($model->description, 100, '...')]);
$this->registerMetaTag(['name' => 'description', 'Резюме ' . $model->employer->second_name . ' ' . $model->employer->first_name .
    ', на должность ' . $model->title . '. Опыт работы: ' . $exp . '. ' .
    ' Размещено ' . Yii::$app->formatter->asDate($model->update_time, 'dd.MM.yyyy')]);
$this->registerMetaTag(['name' => 'og:title', 'content' => $model->title]);
$this->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
$this->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
$this->registerMetaTag(['name' => 'og:image', 'content' => $model->image_url ?: '/images/og_image.jpg']);
$this->registerMetaTag(['name' => 'og:description', 'content' => StringHelper::truncate($model->description, 100, '...')]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->request->hostInfo . '/resume/view/' . $model->id]);

?>

<div class="resume">
    <img class="resume__dots2" src="/images/bg-dots.png" alt="Точки" role="presentation"/>
    <div class="resume__circle">
    </div>
    <div class="container container-for-sidebar">
        <div class="resume__left">
            <div class="resume-results">
                <ul class="breadcrumbs">
                    <?php if ($model->city0): ?>
                        <li>
                            <a href="<?= Resume::getSearchPageUrl(false, $model->city0->slug) ?>"><?= $model->city0->name ?></a>
                        </li>
                    <?php endif ?>
                    <?php if ($referer_category): ?>
                        <li>
                            <a href="<?= Resume::getSearchPageUrl($referer_category->slug) ?>"><?= $referer_category->name ?></a>
                        </li>
                    <?php endif ?>
                    <li><?= mb_convert_case($model->title, MB_CASE_TITLE) ?></li>
                </ul>
                <div class="resume-results__date">
                    <p>Резюме от</p>
                    <span><?= Yii::$app->formatter->asDate($model->update_time, 'dd MM yyyy') ?></span>
                </div>
            </div>
            <section class="resume-top">
                <img class="resume-top__left" src="<?= $model->image_url ?: '/images/empty_user.jpg' ?>"
                     alt="<?= $model->image_url ? ('Фото ' . $model->employer->second_name . ' ' . $model->employer->first_name) : 'Пустое фото резюме' ?>"
                     role="presentation"
                />
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
                    <h1 class="resume-top__head">Резюме: <?= $model->employer->first_name . ' ' . $model->employer->second_name ?>
                    </h1>
                    <h3 class="resume-description__text">
                        <?= mb_convert_case($model->title, MB_CASE_TITLE) ?>
                    </h3>
                    <span class="resume-top__price">
                        <?php if ($model->min_salary > 0 && $model->max_salary > 0): ?>
                            <?= MoneyFormat::getFormattedAmount($model->min_salary) ?>-<?= MoneyFormat::getFormattedAmount($model->max_salary) ?> ₽
                        <?php elseif ($model->max_salary > 0): ?>
                            До <?= MoneyFormat::getFormattedAmount($model->max_salary) ?> ₽
                        <?php elseif ($model->min_salary > 0): ?>
                            От <?= MoneyFormat::getFormattedAmount($model->min_salary) ?> ₽
                        <?php else: ?>
                            По договоренности
                        <?php endif ?>
                    </span>
                    <table class="resume-top__text">
                        <tbody>
                        <?php if ($model->employer->age > 0): ?>
                            <tr>
                                <th>Возраст:
                                </th>
                                <td><?= $model->employer->age ?>
                                </td>
                            </tr>
                        <?php endif ?>
                        <?php if ($model->employment_type): ?>
                            <tr>
                                <th>Вид занятости:
                                </th>
                                <td><?= $model->employment_type->name ?>
                                </td>
                            </tr>
                        <?php endif ?>
                        <?php if ($model->city0): ?>
                            <tr>
                                <th>Город:
                                </th>
                                <td><?= $model->city0->name ?>
                                </td>
                            </tr>
                        <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="resume-block single-block-slider">
                <section class="resume-description">
                    <?php if ($model->experience): ?>
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
                    <?php endif ?>
                    <?php if ($model->education): ?>
                        <div class="resume-description__item">
                            <h4 class="resume-description__title-main">Образование
                            </h4>
                            <?php foreach ($model->education as $education): ?>
                                <h4 class="resume-description__title-bold">
                                    <?= $education->name ?>
                                </h4>
                                <p class="resume-description__text"><?= $education->academic_degree ?><?php if ($education->academic_degree): ?>,
                                        <br><?php endif ?>
                                    <?php if ($education->year_from && $education->academic_degree): ?>
                                        с <?= $education->year_from ?>
                                    <?php endif ?>
                                    <?php if ($education->year_from && !$education->academic_degree): ?>
                                        С <?= $education->year_from ?>
                                    <?php endif ?>
                                    <?php if ($education->year_to): ?>
                                        по
                                        <?= $education->year_to ?>
                                    <?php endif ?>
                                    <?php if ($education->year_from || $education->year_to): ?>
                                        г.
                                    <?php endif ?>
                                </p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif ?>
                    <?php if ($model->skills): ?>
                        <div class="resume-description__item">
                            <h4 class="resume-description__title-main">Профессиональные и другие навыки
                            </h4>
                            <p class="resume-description__text">

                                <?php
                                $i = true;
                                foreach ($model->skills as $skill) {
                                    if ($i) {
                                        echo $skill->name;
                                        $i = false;
                                    } else {
                                        echo ', ' . $skill->name;
                                    }
                                }
                                ?>.
                            </p>
                        </div>
                    <?php endif ?>
                    <?php if ($model->description): ?>
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
                    <div class="sidebar-inner">
                        <div class="resume-info__head">
                            <?php if (Yii::$app->user->isGuest): ?>
                                <span style="display: flex; flex-direction: column;">
                                    Для просмотра контактных данных <a class="jsLogin"
                                                                       style="text-decoration: none;cursor: pointer">войдите или зарегистрируйтесь</a>
                                </span>
                            <?php else: ?>
                                <h4>Контактная информация
                                </h4>
                                <p>Телефон:
                                </p>
                                <?php if ($model->employer->phone): ?>
                                    <a class="hide-phone jsShowPhone"
                                       href="tel:<?= $model->employer->phone->number ?>"><?= $model->employer->phone->number ?></a>
                                    <button
                                            data-id="<?= $model->id ?>"
                                            data-type="resume"
                                            class="show-phone jsClickShowPhone"
                                            onclick="gtag('event', 'resume_phone', { 'event_category': 'click', 'event_action': 'resume_phone', }); yaCounter53666866.reachGoal('resume_phone'); return true;"
                                    >Показать
                                    </button>
                                <?php endif ?>
                                <p>Почта:
                                </p>
                                <a href="mailto:<?= $model->employer->user->email ?>"><?= $model->employer->user->email ?></a>
                            <?php endif ?>
                        </div>
                        <div class="resume-info__soc">
                            <?php if ($model->hasSocials()): ?>
                                <p>Написать соискателю в сетях</p>
                                <?php if ($model->vk): ?>
                                    <a class="vk-bg" rel="nofollow" target="_blank"
                                       href="https://vk.com/<?= $model->vk ?>">
                                        <img src="/images/vk.svg" alt="Иконка VK" role="presentation"/>
                                    </a>
                                <?php endif ?>
                                <?php if ($model->facebook): ?>
                                    <a class="fb-bg" rel="nofollow" target="_blank"
                                       href="https://facebook.com/<?= $model->facebook ?>">
                                        <img src="/images/fb.svg" alt="Иконка facebook" role="presentation"/>
                                    </a>
                                <?php endif ?>
                                <?php if ($model->instagram): ?>
                                    <a class="inst-bg" rel="nofollow" target="_blank"
                                       href="https://instagram.com/<?= $model->instagram ?>">
                                        <img src="/images/instagram.svg" alt="Иконка instagram" role="presentation"/>
                                    </a>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                        <?php if (!Yii::$app->user->isGuest && $model->owner != Yii::$app->user->id): ?>
                            <button class="resume-info__btn jsSendMessage" data-id="<?= $model->id ?>">написать
                                сообщение
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