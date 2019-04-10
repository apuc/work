<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Vacancy */

$this->title = $model->post;
?>
<div class="root">
    <header class="header-wrap jsHeaderIndex">
        <img class="header-wrap__emblem" src="/images/img2.png" alt="" role="presentation"/>
        <div class="container">
            <div class="header">
                <div class="home__main-top">
                    <div class="home__main-header">
                        <nav class="home__nav">
                            <a class="home__nav-item" href="index.html">Главная</a><a
                                    class="home__nav-item" href="resume.html">Резюме</a>
                            <button class="home__nav-item jsLogin">Вход
                            </button>
                        </nav>
                        <div class="home__main-email d-flex align-items-center"><span class="home__main-ico">@</span><a
                                    href="mailto:info@vendoram.ru">info@vendoram.ru</a>
                        </div>
                        <div class="d-flex align-items-center"><i class="home__main-ico fa fa-phone"></i>
                            <div class="d-flex flex-column"><a href="tel:88003553505">+8 800 355-35-05</a><a
                                        class="home__callback" href="#">Заказать обратный звонок</a>
                            </div>
                        </div>
                    </div>
                    <div class="home__main-content">
                        <form class="home__form"><input class="home__form-input" placeholder="Я ищу..." type="text"/>
                            <div class="home__form-select">
                                <select class="home__form-select-js">
                                    <option></option>
                                    <option>Пункт 1</option>
                                    <option>Пункт 2</option>
                                    <option>Пункт 3</option>
                                </select>
                            </div>
                            <button class="home__search btn-red" type="submit"><i class="fa fa-search"></i>
                            </button>
                        </form>
                        <a class="btn btn-red mr20" href="#">разместить резюме</a><a class="btn btn-red"
                                                                                     href="all-vacancies.html">Найти
                            вакансии</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="single-vacancy"><img class="single-vacancy__dots2" src="/images/bg-dots.png" alt=""
                                         role="presentation"/>
        <div class="single-vacancy__circle">
        </div>
        <div class="container">
            <p class="result-search">Результаты поиска · <?=$model->city?> ·<span><?=$model->post?></span>
            </p>
            <div class="single-block single-block-slider">
                <button class="mobile-contacts jsShowContacts jsShowContactsFlag"><img
                            src="/images/add-contact.svg" alt="" role="presentation"/>
                </button>
                <div class="single-block__left">
                    <div class="single-block__left__first">
                        <?php foreach($model->category as $category):?>
                        <a class="btn-card btn-card-small btn-gray" href="#"><?=$category->name?></a>
                        <?php endforeach ?>
                        <span>Добавлено:<br> <?= Yii::$app->formatter->asDate($model->created_at, 'dd MM yyyy')?></span>
                        <div class="single-block__left__first__view"><img class="single-block__icon mr5"
                                                                          src="/images/icon-eye.png" alt=""
                                                                          role="presentation"/><span><?=$model->views?></span>
                        </div>
                        <a class="single-block__left__first__city d-flex align-items-center ml-auto mt5 mb5"
                           href="#"><img class="single-block__icon" src="/images/arr-place.png" alt=""
                                         role="presentation"/><span class="ml5"><?=$model->city?></span></a>
                    </div>
                    <h3 class="single-block__left__head"><?=$model->post?>
                    </h3>
                    <div class="single-block__left__price"><span><?=$model->min_salary?>-<?=$model->max_salary?> RUB</span>
                        <div class="single-block__left__price__soc">
                            <?php if($model->company->hasSocials()):?>
                            <span>Написать соискателю в сетях</span>
                                <?php if($model->company->vk):?><a class="vk-bg" href="<?=$model->company->vk?>"><img src="/images/vk.svg" alt="" role="presentation"/></a><?php endif?>
                                <?php if($model->company->instagram):?><a class="ok-bg" href="<?=$model->company->instagram?>"><img src="/images/ok.svg" alt="" role="presentation"/></a><?php endif?>
                                <?php if($model->company->facebook):?><a class="fb-bg" href="<?=$model->company->facebook?>"><img src="/images/fb.svg" alt="" role="presentation"/></a><?php endif?>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="single-block__left__employment">
                        <h3 class="single-block__left__employment__head">Вид занятости:
                        </h3>
                        <p class="single-block__left__employment__text"><?=$model->employment_type->name?>
                        </p>
                    </div>
                    <div class="single-block__left__description">
                        <h3 class="single-block__left__description__head">Описание вакансии
                        </h3>
                        <p class="single-block__left__requirements__text"><?=$model->company->description?></p>
                    </div>
                    <div class="single-block__left__requirements">
                        <h3 class="single-block__left__requirements__head">Требования:
                        </h3>
                        <p class="single-block__left__requirements__text"><?=$model->qualification_requirements?></p>
                    </div>
                    <div class="single-block__left__duties">
                        <h3 class="single-block__left__duties__head">Обязаности
                        </h3>
                        <p class="single-block__left__duties__text"><?=$model->responsibilities?></p>
                    </div>
                    <div class="single-block__left__conditions">
                        <h3 class="single-block__left__conditions__head">Условия работы:
                        </h3>
                        <p class="single-block__left__conditions__text"><?=$model->working_conditions?></p>
                    </div>
                </div>
                <div class="single-block__right sidebar-single jsOpenContacts" id="sidebar-single">
                    <div class="single-vacancy-overlay jsHideContacts">
                    </div>
                    <div class="sidebar-inner">
                        <button class="mobile-contacts sidebar-mobile-contacts jsShowContacts"><img
                                    src="/images/add-contact.svg" alt="" role="presentation"/>
                        </button>
                        <div class="sr-block">
                            <div class="sr-block__image"><img src="/images/logo_company.svg" alt=""
                                                              role="presentation"/>
                            </div>
                            <div class="sr-block__text">
                                <h3 class="sr-block__text__company">Компания:
                                </h3>
                                <p class="sr-block__text__c-name"><?=$model->company->name?>
                                </p>
                                <p class="sr-block__text__c-name"><?=$model->company->activity_field?>
                                </p>
                                <h3 class="sr-block__text__contact">Контактное лицо:
                                </h3>
                                <p class="sr-block__text__cont-name"><?=$model->company->contact_person?>
                                </p>
                                <h3 class="sr-block__text__phone">Телефон:</h3>
                                <?php foreach ($model->company->phone as $phone):?>
                                <a class="sr-block__text__p-num" href="tel:<?=$phone->number?>"><?=$phone->number?></a>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="sr-btn">
                            <button class="sr-btn__btn btn btn-red">Отправить резюме
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal-block jsModal">
        <div class="modal-overlay jsModalClose">
        </div>
        <div class="modal-position">
            <div class="modal-close jsModalClose"><span></span><span></span>
            </div>
            <div class="modal-style modal-login jsModalLogin">
                <h2>Вход
                </h2>
                <form class="jsModalLoginForm"><input class="jsMail" type="email" name="email"
                                                      placeholder="Электронная почта"/><input class="jsPass"
                                                                                              type="password"
                                                                                              name="pass"
                                                                                              placeholder="Пароль"/>
                    <button class="jsBtnLogin jsBtn" type="submit" disabled="disabled">Войти
                    </button>
                </form>
                <div class="modal-style__text"><span>Забыли пароль?</span>
                    <button class="jsRegForm">Зарегитрироваться
                    </button>
                </div>
            </div>
            <div class="modal-style modal-reg jsModalReg">
                <h2>Регистрация
                </h2>
                <form class="jsModalRegForm"><input class="jsName" type="text" name="name" placeholder="Имя"/><input
                            class="jsSurname" type="text" name="surname" placeholder="Фамилия"/><input class="jsMail"
                                                                                                       type="email"
                                                                                                       name="email"
                                                                                                       placeholder="Электронная почта"/><input
                            class="jsPass" type="password" name="pass" placeholder="Пароль"/>
                    <button class="jsBtnReg jsBtn" type="submit" disabled="disabled">Зарегистрироваться
                    </button>
                </form>
                <div class="modal-style__text"><span>Есть учетная запись?</span>
                    <button class="jsLoginForm">Войти
                    </button>
                </div>
            </div>
            <div class="modal-style modal-error jsModalError">
                <h2>Ошибка ввода
                </h2>
                <div class="modal-style__circle">
                    <div class="modal-style__circle__center"><img src="/images/checked.svg" alt=""
                                                                  role="presentation"/>
                    </div>
                </div>
                <span class="modal-style__error-text">Вы ввели не верные данные вернитесь и заполните форму верное</span>
            </div>
        </div>
    </div>
</div>