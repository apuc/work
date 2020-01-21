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
                    ['label' => 'Пользователи', 'url' => ['/user/admin/index']],
                    ['label' => 'Работодатели', 'url' => ['/company/company/index']],
                    ['label' => 'Сотрудники', 'url' => ['/employer/employer/index']],
                    ['label' => 'Резюме', 'url' => ['/resume/resume/index']],
                    ['label' => 'Вакансии', 'url' => ['/vacancy/vacancy/index']],
                    ['label' => 'Опыт', 'url' => ['/experience/experience/index']],
                    ['label' => 'Образование', 'url' => ['/education/education/index']],
                    ['label' => 'Умения', 'url' => ['/skill/skill/index']],
                    ['label' => 'Категории', 'url' => ['/category/category/index']],
                    ['label' => 'Переменные', 'url' => ['/key_value/key-value/index']],
                    ['label' => 'Города', 'url' => ['/cities/cities/index']],
                    ['label' => 'Новости', 'url' => ['/news/news/index']],
                    [
                            'label' => 'Рассылка почты', 'url' => '#',
                        'items' => [
                                ['label' => 'Управление рассылкой', 'icon' => 'mail', 'url' => ['/mail_delivery/mail-delivery/index']],
                                ['label' => 'Шаблоны', 'icon' => 'sheet', 'url' => ['/mail_delivery/templates/index']],
                        ],
                    ],
                    ['label' => 'Тэги', 'url' => ['/tags/tags/index']],
                    ['label' => 'Просмотры', 'url' => ['/views/views/index']],
                    ['label' => 'Профессии', 'url' => ['/professions/professions/index']],
                    ['label' => 'Тест', 'url' => ['/test/default/index']],
                ],
            ]
        ) ?>

    </section>

</aside>
