<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Resume */

$this->title = $model->title;
?>

<div class="root">
    <header class="header-wrap jsHeaderIndex">
        <img class="header-wrap__emblem"
             src="/images/img2.png" alt=""
             role="presentation"/>
        <div class="container">
            <div class="header">
                <div class="home__main-top">
                    <div class="home__main-header">
                        <nav class="home__nav"><a class="home__nav-item" href="index.html">Главная</a><a
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
                        <li><a href="#"><?=$model->city?></a>
                        </li>
                        <li><a href="#"><?=$model->title?></a>
                        </li>
                    </ul>
                    <div class="resume-results__date">
                        <p>Резюме от
                        </p><span><!--6 марта 2019--><?= Yii::$app->formatter->asDate($model->created_at, 'dd MM yyyy')?></span>
                    </div>
                </div>
                <div class="resume-top"><img class="resume-top__left" src="/images/resume_image_1.png" alt=""
                                             role="presentation"/>
                    <div class="resume-top__right">
                        <div class="resume-top__header">
                            <button class="resume-top__download"><img src="/images/resume_download.png" alt=""
                                                                      role="presentation"/><span>Скачать<br> резюме</span>
                            </button>
                            <button class="resume-top__save">Сохранить в отклики
                            </button>
                            <p class="resume-top__status vr-head">Онлайн
                            </p>
                        </div>
                        <h3 class="resume-top__head"><?=$model->title?>
                        </h3><span class="resume-top__price">260-400 EUR</span>
                        <table class="resume-top__text">
                            <tbody>
                            <tr>
                                <th>Занятость:
                                </th>
                                <td>частичная занятость, проектная работа, полная занятость
                                </td>
                            </tr>
                            <tr>
                                <th>Возраст:
                                </th>
                                <td>38 лет
                                </td>
                            </tr>
                            <tr>
                                <th>Город:
                                </th>
                                <td>Горловка
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
                                </h4><span class="resume-description__experience">6 лет 9 месяцев</span>
                            </div>
                            <h4 class="resume-description__title-bold">Механик участка филиала в Туркменистане
                            </h4>
                            <p class="resume-description__text">с 07.2015 по 12.2016 (1 год 5 месяцев)
                            </p>
                            <p class="resume-description__text">Дорожное строительство"Альтком", Туркменабад (Дорожное
                                строительство)
                            </p>
                            <h4 class="resume-description__title-bold">Главный инженер
                            </h4>
                            <p class="resume-description__text">с 04.2012 по 07.2015 (3 года 3 месяца)
                            </p>
                            <p class="resume-description__text">
                                ГП" Артемуголь", Горловка (Мат-но тех.снабж. и вспомогательное пр-во(автобаза(самосвалы,
                                краны,вышки, бульдозера, экскаваторы), строй уч-ок, лесные склады с переработкой сырья,
                                РММ, тушение профилактика териконов и рекультив. земель)
                            </p>
                            <h4 class="resume-description__title-bold">Начальник
                            </h4>
                            <p class="resume-description__text">с 07.2011 по 04.2012 (9 месяцев)
                            </p>
                            <p class="resume-description__text">ГП" Артемуголь", Горловка (Ремонтно строительный
                                участок)
                            </p>
                        </div>
                        <div class="resume-description__item">
                            <h4 class="resume-description__title-main">Образование
                            </h4>
                            <h4 class="resume-description__title-bold">Горловский жилищно-комунальный техникум
                            </h4>
                            <p class="resume-description__text">Горловка <br>Среднее специальное, <br>с 09.1995 по
                                03.1999 (3 года 6 месяцев)
                            </p>
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
                                Здоровый образ жизни, спорт, самообучение, участие в обучающих программах и тренингах,
                                основной приоритетв трудовой деятельности - увлеченность работой приносящей результат и
                                самореализация. Готовность к проектам высокого уровня сложности .
                                Рассматриваю предложения с оплатой по конкретным результатам работы. Возможность
                                использования личного авто.
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
                                </p><a href="tel:0508798669">050-879-86-69</a><a href="tel:0713406501">071-340-65-01</a>
                                <p>Почта:
                                </p><a href="mailto:ansa@mail.ru">ansa@mail.ru</a>
                            </div>
                            <div class="resume-info__soc">
                                <p>Написать соискателю в сетях
                                </p><a class="vk-bg" href="#"><img src="/images/vk.svg" alt=""
                                                                   role="presentation"/></a><a class="ok-bg"
                                                                                               href="#"><img
                                            src="/images/ok.svg" alt="" role="presentation"/></a><a class="fb-bg"
                                                                                                    href="#"><img
                                            src="/images/fb.svg" alt="" role="presentation"/></a>
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