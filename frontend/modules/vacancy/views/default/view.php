<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Vacancy */
/* @var $last_vacancies \common\models\Vacancy[] */

/* @var $referer_category \common\models\Category */

use common\classes\MoneyFormat;
use common\models\City;
use common\models\Vacancy;
use yii\helpers\StringHelper;

if ($model->min_salary && $model->max_salary)
    $money_string = MoneyFormat::getFormattedAmount($model->min_salary) . '-' . MoneyFormat::getFormattedAmount($model->max_salary) . '₽';
elseif ($model->min_salary)
    $money_string = MoneyFormat::getFormattedAmount($model->min_salary) . '₽';
elseif ($model->max_salary)
    $money_string = MoneyFormat::getFormattedAmount($model->max_salary) . '₽';
else
    $money_string = 'Зарплата договорная';


if ($model->company->name)
    $title = 'Вакансия: ' . ucfirst($model->post) . ' - в ' . ($model->city0 ? $model->city0->prepositional : '') . ', ' . $model->company->name;
else
    $title = 'Вакансия: ' . ucfirst($model->post) . ','  .
        ' в ' . ($model->city0 ? $model->city0->prepositional : '') . ', ' . $money_string . ', ' . 'размещено ' .Yii::$app->formatter->asDate($model->update_time, 'dd.MM.yyyy');

if ($model->company->name) {
    $description = 'Вакансия ' . $model->post . ' в компании ' . $model->company->name . 'в категории ' .
        $model->mainCategory->name . ', г' . $model->city0->name . ',' .
        $model->city0->region->name .
        '. Размещено ' . Yii::$app->formatter->asDate($model->update_time, 'dd MM yyyy');
} else {
    $description = 'Вакансия ' . $model->post . ' в категории ' .
        $model->mainCategory->name . ', г' . $model->city0->name . ',' .
        $model->city0->region->name . ' Контактное лицо ' . $model->company->contact_person .
        '. Размещено ' . Yii::$app->formatter->asDate($model->update_time, 'dd MM yyyy');
}
$this->title = $title;
$this->registerMetaTag(['name' => 'description', $description]);
$this->registerMetaTag(['name' => 'og:title', 'content' => $title]);
$this->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
$this->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
$this->registerMetaTag(['name' => 'og:image', 'content' => $model->company->image_url ?: '/images/og_image.jpg']);
$this->registerMetaTag(['name' => 'og:description', 'content' => StringHelper::truncate($model->qualification_requirements, 100, '...')]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->request->hostInfo . '/vacancy/view/' . $model->id]);

?>

<section class="single-vacancy">
    <img class="single-vacancy__dots2" src="/images/bg-dots.png" alt="точки" role="presentation"/>
    <div class="single-vacancy__circle"></div>
    <div class="container">
        <div class="resume-results">
            <ul class="breadcrumbs">
                <?php if ($model->city0): ?>
                    <li>
                        <a href="<?= Vacancy::getSearchPageUrl(false, $model->city0->slug) ?>"><?= $model->city0->name ?></a>
                    </li>
                <?php endif ?>
                <?php if ($referer_category && $referer_category->name !== 'Пустая категория'): ?>
                    <li>
                        <a href="<?= Vacancy::getSearchPageUrl($referer_category->slug, $model->city0 ? $model->city0->slug : false) ?>"><?= $referer_category->name ?></a>
                    </li>
                <?php endif ?>
                <li><?= mb_convert_case($model->post, MB_CASE_TITLE) ?></li>
            </ul>
        </div>
        <div class="single-block single-block-slider" itemscope="itemscope" itemtype="http://schema.org/JobPosting">
            <meta itemprop="url" content="<?= Yii::$app->request->getHostInfo() . "/vacancy/view/" . $model->id ?>>">
            <?php foreach ($model->category as $category): ?>
                <meta itemprop="industry" content="<?= $category->name ?>">
            <?php endforeach; ?>
            <div class="single-block__left">
                <img class="single-block__logo" src="<?= $model->company->getPhotoOrEmptyPhoto($model->mainCategory) ?>"
                     alt="<?= $model->company->image_url ? ('Логотив компани ' . $model->company->name) : 'Пустая компания' ?>"
                     role="presentation"/>
                <div class="single-block__first">
                    <?php if ($model->mainCategory->name !== 'Пустая категория'): ?>
                        <div class="category-block">
                            <a class="btn-card btn-card-small btn-gray"
                               href="<?= \common\models\Vacancy::getSearchPageUrl($model->mainCategory->slug) ?>"><?= $model->mainCategory->name ?></a>
                            <?php foreach ($model->category as $category): ?>
                                <?php if ($category->id != $model->main_category_id): ?>
                                    <a class="btn-card btn-card-small btn-gray"
                                       href="<?= \common\models\Vacancy::getSearchPageUrl($category->slug) ?>"><?= $category->name ?></a>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                    <span>Добавлено:<br> <?= Yii::$app->formatter->asDate($model->created_at, 'dd.MM.yyyy') ?></span>
                    <div class="single-block__view">
                        <img class="single-block__icon mr5" src="/images/icon-eye.png" alt="Иконка глаз"
                             role="presentation"/>
                        <span><?= $model->countViews ?></span>
                    </div>
                    <?php if ($model->city0): ?>
                        <a class="single-block__city d-flex align-items-center ml-auto mt5 mb5"
                           href="<?= \common\models\Vacancy::getSearchPageUrl(false, $model->city0->slug) ?>">
                            <img class="single-block__icon" src="/images/arr-place.png" alt="Стрелка"
                                 role="presentation"/>
                            <span class="ml5"><?= $model->city0->name ?></span>
                        </a>
                    <?php endif ?>
                </div>

                <!--<div class="profession-block">
                       <?php /*foreach ($model['pro'] as $key => $value): */?>
                           <a href="<?/*= \common\models\Vacancy::getSearchPageUrl(false, false, $value['slug']) */?>"><p> <?/*= $value['title']*/?> </p></a>
                    <?php /*endforeach;*/?>
                </div>-->
                <h1 class="single-block__head" itemprop="title">
                    <?= mb_convert_case($model->post, MB_CASE_TITLE) ?>
                </h1>
                <span itemprop="baseSalary" itemscope="" itemtype="http://schema.org/MonetaryAmount">
                    <meta itemprop="currency" content="RUB">
                    <span itemprop="value" itemscope="" itemtype="http://schema.org/QuantitativeValue">
                        <meta itemprop="minValue" content="<?= $model->min_salary ?>">
                        <meta itemprop="maxValue" content="<?= $model->max_salary ?>">
                        <meta itemprop="unitText" content="MONTH">
                    </span>
                </span>
                <div class="single-block__price">
                    <span><?= $money_string ?></span>
                    <?php if (Yii::$app->user->isGuest && $model->company->hasSocials()): ?>
                        <div>
                            <button class="btn-for-login jsLogin">Войдите или зарегистрируйтесь</button>
                            что-бы увидеть контакты работодателя
                        </div>
                    <?php else: ?>
                        <div class="single-block__soc">
                            <?php if ($model->company->hasSocials()): ?>
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <span>Написать работодателю в соц.сетях</span>
                                    <?php if ($model->company->vk): ?>
                                        <a class="vk-bg" rel="nofollow" target="_blank"
                                           href="https://vk.com/<?= $model->company->vk ?>">
                                            <img src="/images/vk.svg" alt="Иконка VK" role="presentation"/>
                                        </a>
                                    <?php endif ?>
                                    <?php if ($model->company->instagram): ?>
                                        <a class="inst-bg" rel="nofollow" target="_blank"
                                           href="https://instagram.com/<?= $model->company->instagram ?>">
                                            <img src="/images/instagram.svg" alt="Иконка instagram"
                                                 role="presentation"/>
                                        </a>
                                    <?php endif ?>
                                    <?php if ($model->company->facebook): ?>
                                        <a class="fb-bg" rel="nofollow" target="_blank"
                                           href="https://facebook.com/<?= $model->company->facebook ?>">
                                            <img src="/images/fb.svg" alt="Иконка facebook" role="presentation"/>
                                        </a>
                                    <?php endif ?>
                                <?php endif; ?>
                            <?php endif ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($model->employment_type): ?>
                    <div class="single-block__employment">
                        <h3 class="single-block__employment-head">Вид занятости:
                        </h3>
                        <p class="single-block__employment-text"><?= $model->employment_type->name ?>
                        </p>
                    </div>
                <?php endif ?>
                <?php if ($model->description): ?>
                    <div class="single-block__description">
                        <h3 class="single-block__description-head">Описание вакансии
                        </h3>
                        <p class="single-block__requirements-text"><?= $model->description ?></p>
                    </div>
                <?php endif ?>
                <?php if ($model->qualification_requirements): ?>
                    <div class="single-block__requirements">
                        <h3 class="single-block__requirements-head">Требования:
                        </h3>
                        <p class="single-block__requirements-text"><?= nl2br($model->qualification_requirements) ?></p>
                    </div>
                <?php endif ?>
                <?php if ($model->responsibilities): ?>
                    <div class="single-block__duties">
                        <h3 class="single-block__duties-head">Обязанности:
                        </h3>
                        <p class="single-block__duties-text"><?= nl2br($model->responsibilities) ?></p>
                    </div>
                <?php endif ?>
                <?php if ($model->work_experience !== null): ?>
                    <div class="single-block__employment">
                        <h3 class="single-block__employment-head">Необходимый опыт работы:
                        </h3>
                        <p class="single-block__employment-text"><?= Vacancy::$experiences[$model->work_experience] ?>
                        </p>
                    </div>
                <?php endif ?>
                <?php if ($model->education): ?>
                    <div class="single-block__employment">
                        <h3 class="single-block__employment-head">Необходимое образование:
                        </h3>
                        <p class="single-block__employment-text"><?= $model->education ?>
                        </p>
                    </div>
                <?php endif ?>
                <?php if ($model->working_conditions): ?>
                    <div class="single-block__conditions">
                        <h3 class="single-block__conditions-head">Условия работы:
                        </h3>
                        <p class="single-block__conditions-text"><?= nl2br($model->working_conditions) ?></p>
                    </div>
                <?php endif ?>
            </div>
            <aside class="single-block__right sidebar-single jsOpenContacts" id="sidebar-single">
                <div class="sidebar-inner">
                    <span itemprop="identifier" itemscope="" itemtype="http://schema.org/PropertyValue">
                        <meta itemprop="name" content="<?= $model->company->name ?>">
                        <meta itemprop="value" content="<?= $model->id ?>">
                    </span>
                    <div class="sr-block" itemscope="itemscope" itemtype="https://schema.org/Organization">
                        <meta itemprop="name" content="<?= $model->company->name ?>">
                        <?php if (Yii::$app->user->isGuest): ?>
                        <ul class="sr-block__text">
                            <?php if (!empty($model->company->name)): ?>
                                <li class="sr-block__text__company">
                                    <strong>Компания:</strong><br><a href="/company/view/<?= $model->company_id ?>"><?= $model->company->name ?>
                                        <br> <?= $model->company->activity_field ?>
                                    </a>
                                </li>
                            <?php endif ?>
                            <span style="display: flex; flex-direction: column;">
                                    Для просмотра контактных данных <a href="#" class="jsLogin"
                                                                       style="text-decoration: none;">войдите или зарегистрируйтесь</a>
                                </span>
                        <?php else: ?>
                            <ul class="sr-block__text">
                                <?php if (!empty($model->company->name)): ?>
                                    <li class="sr-block__text__company">
                                        <strong>Компания:</strong><br><a href="/company/view/<?= $model->company_id ?>"><?= $model->company->name ?>
                                            <br> <?= $model->company->activity_field ?>
                                        </a>
                                    </li>
                                <?php endif ?>
                                <li class="sr-block__text__contact">
                                    <p><strong>Контактное лицо:</strong><?= $model->company->contact_person ?>
                                    </p>
                                </li>
                                <?php /*if (!empty($model->company->name)): */?><!--
                                    <li class="sr-block__text__company">
                                        <a href="/company/view/<?/*= $model->company_id */?>"><strong>Компания:</strong><br><?/*= $model->company->name */?>
                                            <br> <?/*= $model->company->activity_field */?>
                                        </a>
                                    </li>
                                <?php /*endif */?>
                                <li class="sr-block__text__contact">
                                    <p><strong>Контактное лицо:</strong><?/*= $model->company->contact_person */?>
                                    </p>
                                </li>-->
                                <?php if ($model->publisher->employer->phone): ?>
                                    <li class="sr-block__text__phone">
                                        <img src="/images/phone.svg" alt="Телефон" role="presentation"/>
                                        <div>
                                            <strong>Телефон:</strong>
                                            <a class="hide-phone jsShowPhone"
                                               href="tel:<?= $model->publisher->employer->phone->number ?>"><?= $model->publisher->employer->phone->number ?></a>
                                            <button
                                                    data-id="<?= $model->id ?>"
                                                    data-type="vacancy"
                                                    class="show-phone jsClickShowPhone"
                                                    onclick="gtag('event', 'vacancy_phone', { 'event_category': 'click', 'event_action': 'vacancy_phone', }); yaCounter53666866.reachGoal('vacancy_phone'); return true;"
                                            >Показать
                                            </button>
                                        </div>
                                    </li>
                                <?php endif ?>
                            </ul>
                        <?php endif ?>
                    </div>
                    <div class="sr-btn">
                        <button class="sr-btn__btn btn btn-red <?= Yii::$app->user->isGuest ? 'jsLogin' : 'jsVacancyModal' ?>"
                                data-id="<?= $model->id ?>">Отправить
                            резюме
                        </button>
                    </div>
                    <div class="last-vacancy pc-last-vacancy">
                        <p class="last-vacancy__head">Последние вакансии
                        </p>
                        <?php foreach ($last_vacancies as $vacancy): ?>
                            <div class="last-vacancy__item">
                                <div class="last-vacancy__tr">
                                </div>
                                <div class="last-vacancy__header">
                                    <img src="<?= $vacancy->company->getPhotoOrEmptyPhoto($vacancy->mainCategory) ?>"
                                         alt="<?= $vacancy->company->image_url ? ('Логотив компани ' . $vacancy->company->name) : 'Пустая компания' ?>"
                                         role="presentation"
                                    />
                                    <div class="last-vacancy__top">
                                        <?php if ($vacancy->mainCategory): ?>
                                            <div class="last-vacancy__cat-city">
                                                <a class="btn-card btn-card-small btn-gray"
                                                   href="<?= Vacancy::getSearchPageUrl($vacancy->mainCategory->slug) ?>"><?= $vacancy->mainCategory->name ?></a>
                                            </div>
                                        <?php endif ?>
                                        <a class="last-vacancy__title" href="/vacancy/view/<?= $vacancy->id ?>"
                                           title="<?= mb_convert_case($vacancy->post, MB_CASE_TITLE) ?>"><?= mb_convert_case($vacancy->post, MB_CASE_TITLE) ?></a>
                                    </div>
                                </div>
                                <div class="last-vacancy__info">
                                    <p>
                                        <?= StringHelper::truncate($vacancy->responsibilities, 200, '...') ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>
            <div class="last-vacancy mob-last-vacancy">
                <p class="last-vacancy__head">Последние вакансии
                </p>
                <?php foreach ($last_vacancies as $vacancy): ?>
                    <div class="last-vacancy__item">
                        <div class="last-vacancy__tr">
                        </div>
                        <div class="last-vacancy__header">
                            <img src="<?= $vacancy->company->getPhotoOrEmptyPhoto($vacancy->mainCategory) ?>"
                                 alt="<?= $vacancy->company->image_url ? ('Логотив компани ' . $vacancy->company->name) : 'Пустая компания' ?>"
                                 role="presentation"
                            />
                            <div class="last-vacancy__top">
                                <?php if ($vacancy->category): ?>
                                    <div class="last-vacancy__cat-city">
                                        <a class="btn-card btn-card-small btn-gray"
                                           href="<?= Vacancy::getSearchPageUrl($vacancy->category[0]->slug) ?>"><?= $vacancy->category[0]->name ?></a>
                                    </div>
                                <?php endif ?>
                                <a class="last-vacancy__title" href="/vacancy/view/<?= $vacancy->id ?>"
                                   title="<?= mb_convert_case($vacancy->post, MB_CASE_TITLE) ?>"><?= mb_convert_case($vacancy->post, MB_CASE_TITLE) ?></a>
                            </div>
                        </div>
                        <div class="last-vacancy__info">
                            <p>
                                <?= StringHelper::truncate($vacancy->responsibilities, 200, '...') ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<script>
    console.log(123);
    VK.Retargeting.Init('VK-RTRG-443042-1VhMa');
    VK.Retargeting.Event('vacancy_search');
</script>