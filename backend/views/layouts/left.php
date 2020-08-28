<aside class="main-sidebar">

    <section class="sidebar">

<!--        Sidebar security panel -->
<!--        <div class="security-panel">-->
<!--            <div class="pull-left image">-->
<!--                <img src="--><?//= $directoryAsset ?><!--/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>-->
<!--            </div>-->
<!--            <div class="pull-left info">-->
<!--                <p>--><?//=Yii::$app->security->identity->username?><!--</p>-->
<!---->
<!--                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
<!--            </div>-->
<!--        </div>-->

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Поиск..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Статистика', 'url' => ['/'], 'icon' => 'bar-chart'],
                    [
                        'label' => 'Пользователи', 'url' => '#', 'icon'=>'users',
                        'items' => [
                            ['label' => 'Пользователи', 'url' => ['/user-list/index'],  'icon'=>'user-circle '],
                            ['label' => 'Работодатели', 'url' => ['/company/company/index'], 'icon' => 'empire'],
                            ['label' => 'Сотрудники', 'url' => ['/employer/employer/index'], 'user-o'],
                        ],
                    ],
                    [
                        'label' => 'Резюме', 'url' => '#', 'icon'=>'id-card-o',
                        'items' => [
                            ['label' => 'Все резюме', 'url' => ['/resume/resume/index'], 'icon' => 'id-card-o'],
                            ['label' => 'Нуждающиеся в аудите', 'url' => ['/resume/resume/index?ResumeSearch[audit_status]='.\common\models\Resume::AUDIT_STATUS_NEEDED], 'icon' => 'id-card-o'],
                            ['label' => 'Прошедшие аудит', 'url' => ['/resume/resume/index?ResumeSearch[audit_status]='.\common\models\Resume::AUDIT_STATUS_FINISHED], 'icon' => 'id-card-o'],

                        ],
                    ],
                    ['label' => 'Вакансии', 'url' => ['/vacancy/vacancy/index'], 'icon' => 'address-book-o'],
                    ['label' => 'Баннеры', 'url' => ['/banner/banner/index'], 'icon' => 'thumb-tack'],
                    [
                        'label' => 'Характеристики', 'url' => '#', 'icon'=>'cog',
                        'items' => [
                            ['label' => 'Опыт', 'url' => ['/experience/experience/index'], 'icon' => 'check-square'],
                            ['label' => 'Образование', 'url' => ['/education/education/index'], 'icon' => 'check-square'],
                            ['label' => 'Умения', 'url' => ['/skill/skill/index'], 'icon' => 'check-square'],

                        ],
                    ],
                    [
                        'label' => 'Платежи', 'url' => '#', 'icon' => 'envelope',
                        'items' => [
                            ['label' => 'Валюты Free-Kassa', 'url' => ['/payment/currency/index'], 'icon' => 'money'],
                            ['label' => 'Платежи Free-Kassa', 'url' => ['/payment/free-kassa-payment/index'], 'icon' => 'credit-card'],
                            ['label' => 'Промокоды', 'url' => ['/payment/promocode/index'], 'icon' => 'credit-card'],
                        ],
                    ],
                    ['label' => 'Категории', 'url' => ['/category/category/index'], 'icon' => 'object-group'],
                    ['label' => 'Переменные', 'url' => ['/key_value/key-value/index'], 'icon'=>'cogs',],
                    [
                        'label' => 'Локации', 'url' => '#', 'icon'=>'globe',
                        'items' => [
                            ['label' => 'Города', 'url' => ['/cities/cities/index'], 'icon' => 'building-o'],
                            ['label' => 'Страны', 'url' => ['/country/country/index'],  'icon' => 'flag'],
                        ],
                    ],
                    ['label' => 'Новости', 'url' => ['/news/news/index'], 'icon' => 'newspaper-o'],
                    ['label' => 'Мета данные', 'url' => ['/meta-data/meta-data/index'], 'icon' => 'search-plus'],
                    [
                        'label' => 'Рассылка почты', 'url' => '#', 'icon' => 'envelope',
                        'items' => [
                            ['label' => 'Управление рассылкой', 'icon' => 'cog', 'url' => ['/mail_delivery/mail-delivery/index']],
                            ['label' => 'Шаблоны', 'url' => ['/mail_delivery/templates/index'], 'icon' => 'check-square'],
                        ],
                    ],
                    [
                        'label' => 'Прочее', 'url' => '#', 'icon' => 'bookmark',
                        'items' => [
                            ['label' => 'Тэги', 'url' => ['/tags/tags/index'], 'icon' => 'check-square'],
                            ['label' => 'Просмотры', 'url' => ['/views/views/index'], 'icon' => 'eye'],
                            ['label' => 'Экспорт', 'url' => ['/site/export'], 'icon' => 'check-square'],
                            ['label' => 'Тест', 'url' => ['/test/default/index'], 'icon' => 'check-square'],
                        ],
                    ],
                    ['label' => 'Профессии', 'url' => ['/professions/professions/index'], 'icon' => 'male'],
                    ['label' => 'Спец. Фильтры', 'url' => ['/spec-filters/spec-filters/index'], 'icon' => 'filter'],
                    ['label' => 'Обновления', 'url' => ['/update/update/index'], 'icon' => 'filter'],
                ],
            ]
        ) ?>

    </section>

</aside>
