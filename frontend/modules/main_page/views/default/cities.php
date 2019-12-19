<?php

use yii\helpers\ArrayHelper;

?>
<main>
    <div class="container">
        <h1 class="title">Вакансии по городам</h1>
        <img src="dotted_line.png" class="title__underline" alt="">

        <div class="container__parts">
            <?=
                \kartik\select2\Select2::widget(
                    [
                        'name' => 'CitySelect',
                        'value' => Yii::$app->request->cookies['city'],
                        'data' => ArrayHelper::map(\common\models\City::find()->all(), 'id', 'name'),
                        'options' => ['placeholder' => 'Выберите город', 'id'=>'city_select'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]
                );
            ?>
            <div class="left">
                <p class="region">ДНР ( Донецкая Народная Республика )</p>
                <div class="cities">

                    <ul>
                        <li><a class="city" href="#">Авдеевка</a></li>
                        <li><a class="city" href="#">Амвросиевка</a></li>
                        <li><a class="city" href="#">Артемово</a></li>
                        <li><a class="city" href="#">Артемовск</a></li>
                        <li><a class="city" href="#">Белицкое</a></li>
                        <li><a class="city" href="#">Белозерское</a></li>
                        <li><a class="city" href="#">Волноваха</a></li>
                        <li><a class="city" href="#">Горловка</a></li>
                        <li><a class="city" href="#">Горняк</a></li>
                        <li><a class="city" href="#">Дебальцево</a></li>
                        <li><a class="city" href="#">Дзержинск</a></li>
                        <li><a class="city" href="#">Димитров</a></li>
                        <li><a class="city" href="#">Доброполье</a></li>
                        <li><a class="city" href="#">Докучаевск</a></li>
                        <li><a class="city" href="#">Донецк</a></li>
                        <li><a class="city" href="#">Дружковка</a></li>
                        <li><a class="city" href="#">Енакиево</a></li>

                        <li><a class="city" href="#">Авдеевка</a></li>
                        <li><a class="city" href="#">Амвросиевка</a></li>
                        <li><a class="city" href="#">Артемово</a></li>
                        <li><a class="city" href="#">Артемовск</a></li>
                        <li><a class="city" href="#">Белицкое</a></li>
                        <li><a class="city" href="#">Белозерское</a></li>
                        <li><a class="city" href="#">Волноваха</a></li>
                        <li><a class="city" href="#">Горловка</a></li>
                        <li><a class="city" href="#">Горняк</a></li>
                        <li><a class="city" href="#">Дебальцево</a></li>
                        <li><a class="city" href="#">Дзержинск</a></li>
                        <li><a class="city" href="#">Димитров</a></li>
                        <li><a class="city" href="#">Доброполье</a></li>
                        <li><a class="city" href="#">Докучаевск</a></li>
                        <li><a class="city" href="#">Донецк</a></li>
                        <li><a class="city" href="#">Дружковка</a></li>
                        <li><a class="city" href="#">Енакиево</a></li>
                    </ul>

                </div>

                <img src="dotted_line.png" class="left__underline" alt="">

            </div>

            <div class="right">
                <p class="region">ДНР ( Донецкая Народная Республика )</p>
                <div class="cities">

                    <ul>
                        <li><a class="city" href="#">Авдеевка</a></li>
                        <li><a class="city" href="#">Амвросиевка</a></li>
                        <li><a class="city" href="#">Артемово</a></li>
                        <li><a class="city" href="#">Артемовск</a></li>
                        <li><a class="city" href="#">Белицкое</a></li>
                        <li><a class="city" href="#">Белозерское</a></li>
                        <li><a class="city" href="#">Волноваха</a></li>
                        <li><a class="city" href="#">Горловка</a></li>
                        <li><a class="city" href="#">Горняк</a></li>
                        <li><a class="city" href="#">Дебальцево</a></li>
                        <li><a class="city" href="#">Дзержинск</a></li>
                        <li><a class="city" href="#">Димитров</a></li>
                        <li><a class="city" href="#">Доброполье</a></li>
                        <li><a class="city" href="#">Докучаевск</a></li>
                        <li><a class="city" href="#">Донецк</a></li>
                        <li><a class="city" href="#">Дружковка</a></li>
                        <li><a class="city" href="#">Енакиево</a></li>

                        <li><a class="city" href="#">Авдеевка</a></li>
                        <li><a class="city" href="#">Амвросиевка</a></li>
                        <li><a class="city" href="#">Артемово</a></li>
                        <li><a class="city" href="#">Артемовск</a></li>
                        <li><a class="city" href="#">Белицкое</a></li>
                        <li><a class="city" href="#">Белозерское</a></li>
                        <li><a class="city" href="#">Волноваха</a></li>
                        <li><a class="city" href="#">Горловка</a></li>
                        <li><a class="city" href="#">Горняк</a></li>
                        <li><a class="city" href="#">Дебальцево</a></li>
                        <li><a class="city" href="#">Дзержинск</a></li>
                        <li><a class="city" href="#">Димитров</a></li>
                        <li><a class="city" href="#">Доброполье</a></li>
                        <li><a class="city" href="#">Докучаевск</a></li>
                        <li><a class="city" href="#">Донецк</a></li>
                        <li><a class="city" href="#">Дружковка</a></li>
                        <li><a class="city" href="#">Енакиево</a></li>

                    </ul>

                </div>

                <img src="dotted_line.png" class="right__underline" alt="">

            </div>

        </div>


    </div>


</main>