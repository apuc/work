<?php

/* @var $this \yii\web\View */

use frontend\assets\PersonalAreaAsset;

$this->registerJsFile('/js/chart.js', ['depends' => PersonalAreaAsset::className()]);
$this->registerJsFile('/node_modules/chart.js/dist/Chart.min.js', ['depends' => PersonalAreaAsset::className()]);

?>
<main class="content-wrapper">
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Line chart</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <canvas id="lineChart" style="height:250px"></canvas>
                    </section>
                </div>
            </div>
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Bar chart</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <canvas id="barChart" style="height:230px"></canvas>
                    </section>
                </div>
            </div>
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Area chart</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <canvas id="areaChart" style="height:250px"></canvas>
                    </section>
                </div>
            </div>
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Doughnut chart</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <canvas id="doughnutChart" style="height:250px"></canvas>
                    </section>
                </div>
            </div>
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Pie chart</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <canvas id="pieChart" style="height:250px"></canvas>
                    </section>
                </div>
            </div>
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Scatter chart</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <canvas id="scatterChart" style="height:250px"></canvas>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>