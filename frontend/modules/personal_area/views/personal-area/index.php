<?php

/* @var $this \yii\web\View */

use frontend\assets\PersonalAreaAsset;

$this->title = 'Личный кабинет';
$this->registerJsFile('/node_modules/chart.js/dist/Chart.min.js', ['depends' => PersonalAreaAsset::className()]);
$this->registerJsFile('/node_modules/progressbar.js/dist/progressbar.min.js', ['depends' => PersonalAreaAsset::className()]);
$this->registerJsFile('/js/dashboard.js', ['depends' => PersonalAreaAsset::className()]);

?>
<main class="content-wrapper">
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6">
                        <div class="mdc-card py-3 pl-2 d-flex flex-row align-item-center">
                            <div class="mdc--tile mdc--tile-danger rounded">
                                <i class="mdi mdi-account-settings text-white icon-md"></i>
                            </div>
                            <div class="text-wrapper pl-1">
                                <h3 class="mdc-typography--display1 font-weight-bold mb-1">7459</h3>
                                <p class="font-weight-normal mb-0 mt-0">New projects</p>
                            </div>
                        </div>
                    </div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6">
                        <div class="mdc-card py-3 pl-2 d-flex flex-row align-item-center">
                            <div class="mdc--tile mdc--tile-success rounded">
                                <i class="mdi mdi-basket text-white icon-md"></i>
                            </div>
                            <div class="text-wrapper pl-1">
                                <h3 class="mdc-typography--display1 font-weight-bold mb-1">$7783</h3>
                                <p class="font-weight-normal mb-0 mt-0">Total Sales</p>
                            </div>
                        </div>
                    </div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6">
                        <div class="mdc-card py-3 pl-2 d-flex flex-row align-item-center">
                            <div class="mdc--tile mdc--tile-warning rounded">
                                <i class="mdi mdi-ticket text-white icon-md"></i>
                            </div>
                            <div class="text-wrapper pl-1">
                                <h3 class="mdc-typography--display1 font-weight-bold mb-1">569</h3>
                                <p class="font-weight-normal mb-0 mt-0">Open Tickets</p>
                            </div>
                        </div>
                    </div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6">
                        <div class="mdc-card py-3 pl-2 d-flex flex-row align-item-center">
                            <div class="mdc--tile mdc--tile-primary rounded">
                                <i class="mdi mdi-account-star text-white icon-md"></i>
                            </div>
                            <div class="text-wrapper pl-1">
                                <h3 class="mdc-typography--display1 font-weight-bold mb-1">5785</h3>
                                <p class="font-weight-normal mb-0 mt-0">New Visitors</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4">
                <div class="mdc-card d-flex flex-column">
                    <div class="mdc-layout-grid__inner flex-grow-1">
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3"></div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6 d-flex align-item-center flex-column">
                            <h2 class="mdc-card__title mdc-card__title--large text-center mt-2 mb-2">Time, Practice</h2>
                            <div id="currentBalanceCircle" class="w-100"></div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3"></div>
                    </div>
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <section class="mdc-card__action-footer mt-4 bg-red w-100">
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple">
                                    <i class="mdi mdi-store icon-md"></i>
                                </div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple">
                                    <i class="mdi mdi-phone-plus icon-md"></i>
                                </div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple">
                                    <i class="mdi mdi-share-variant icon-md"></i>
                                </div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple">
                                    <i class="mdi mdi-autorenew icon-md"></i>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4">
                <div class="mdc-card card--with-avatar">
                    <section class="mdc-card__primary">
                        <div class="card__avatar"><img src="../../images/face.jpg" alt=""></div>
                        <h1 class="mdc-card__title">Daniel Russel</h1>
                        <h2 class="mdc-card__subtitle">@danielrussel</h2>
                        <span class="social__icon-badge mdc-twitter mdi mdi-twitter"></span>
                    </section>
                    <section class="mdc-card__supporting-text pt-1">
                        <p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam condimentum sem
                            non mauris euismod hendrerit.Aliquam condimentum sem non mauris euismod hendrerit.</p>
                        <p class="mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam
                            condimentum.</p>
                    </section>
                    <section class="mdc-card__social-footer bg-blue">
                        <div class="col">
                            <small>TWEETS</small>
                            <p>768.8k</p>
                        </div>
                        <div class="col">
                            <small>FOLLOWING</small>
                            <p>186.8k</p>
                        </div>
                        <div class="col">
                            <small>FOLLOWING</small>
                            <p>25.8k</p>
                        </div>
                    </section>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8">
                <div class="mdc-card px-2 py-2">
                    <div id="js-legend" class="chartjs-legend mb-2"></div>
                    <canvas id="dashboard-monthly-analytics" height="205"></canvas>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card table-responsive">
                    <div class="table-heading px-2 px-1 border-bottom">
                        <h1 class="mdc-card__title mdc-card__title--large">Employee status</h1>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-left">Product</th>
                            <th>Cost</th>
                            <th>Sales amount</th>
                            <th>Shipping cost</th>
                            <th>Units sold</th>
                            <th>Profit generated</th>
                            <th>Left in stock</th>
                            <th>Returns</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left">T-shirts</td>
                            <td>250</td>
                            <td>300</td>
                            <td>60</td>
                            <td>3453</td>
                            <td>76</td>
                            <td>453643</td>
                            <td>300</td>
                            <td>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-heart text-blue"></i></div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-forum text-yellow"></i></div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-delete text-red"></i></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">Baseball Hat</td>
                            <td>457</td>
                            <td>204</td>
                            <td>35</td>
                            <td>6754</td>
                            <td>35</td>
                            <td>345623</td>
                            <td>546</td>
                            <td>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-heart text-blue"></i></div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-forum text-yellow"></i></div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-delete text-red"></i></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">Tennis Racket</td>
                            <td>250</td>
                            <td>350</td>
                            <td>38</td>
                            <td>3289</td>
                            <td>45</td>
                            <td>54662</td>
                            <td>278</td>
                            <td>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-heart text-blue"></i></div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-forum text-yellow"></i></div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-delete text-red"></i></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">Gloves</td>
                            <td>250</td>
                            <td>300</td>
                            <td>60</td>
                            <td>3453</td>
                            <td>76</td>
                            <td>453643</td>
                            <td>300</td>
                            <td>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-heart text-blue"></i></div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-forum text-yellow"></i></div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-delete text-red"></i></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">Shoes</td>
                            <td>673</td>
                            <td>457</td>
                            <td>56</td>
                            <td>4467</td>
                            <td>98</td>
                            <td>345723</td>
                            <td>350</td>
                            <td>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-heart text-blue"></i></div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-forum text-yellow"></i></div>
                                <div class="col mdc-button" data-mdc-auto-init="MDCRipple"><i
                                            class="mdi mdi-delete text-red"></i></div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>