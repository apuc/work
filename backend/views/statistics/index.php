<?php
/* @var $this View */
/* @var $dates array */
/* @var $type integer */
/* @var $total integer */

use backend\controllers\StatisticsController;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\web\View;

$this->registerJsFile('/secure/js/Chart.bundle.min.js', ['position'=>View::POS_HEAD]);
$this->registerJsFile('/secure/js/statisticsPageScript.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->title = "Статистика: " . StatisticsController::$types[$type];
?>
<?= Html::beginForm('', 'GET');?>
<?= Html::dropDownList('type', $type, StatisticsController::$types, ['class'=>'form-control', 'id'=>'chart_type'])?>
<br>
<?= Html::dropDownList('view_type',
    Yii::$app->request->get('view_type')?:0,
    ['', 'Авторизованные пользователи', 'Неавторизованные пользователи'],
    [
        'class'=> ($type==3 || $type==4)?'form-control':'form-control hidden',
        'id'=>'view_type'
    ])
?>
<br>
<?=Html::label('От:', 'date1')?>
<?= DatePicker::widget([
    'name'=>'date1',
    'value'=>Yii::$app->request->get('date1')?:date('d.m.Y', time()-777600),
    'pluginOptions' => [
        'format' => 'dd.mm.yyyy',
        'todayHighlight' => true
    ]
])?>
<br>
<?=Html::label('До:', 'date2')?>
<?= DatePicker::widget([
    'name'=>'date2',
    'value'=>Yii::$app->request->get('date2')?:date('d.m.Y'),
    'pluginOptions' => [
        'format' => 'dd.mm.yyyy',
        'todayHighlight' => true
    ]
])?>
<br>
<?=Html::submitButton('Применить', ['class'=>'btn btn-success'])?>
<div style="width: 1000px;height: 400px;">
    <h4 style="text-align: center">Всего за период: <strong><?=$total?></strong></h4>
<canvas id="myChart"></canvas>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($dates['dates'] as $date)
                    echo "'$date', ";
                ?>
            ],
            datasets: [{
                label: '<?=$dates['label']?>',
                data: [
                    <?php foreach ($dates['data'] as $count)
                    echo "$count, ";
                    ?>
                ],
                backgroundColor: [
                    <?php for ($i=0;$i<count($dates['data']);$i++):?>
                    'rgba(<?=rand(0,255)?>, <?=rand(0,255)?>, <?=rand(0,255)?>, 0.5)',
                    <?php endfor;?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
        }
    });
</script>
</div>

<?= \yii\helpers\Html::endForm();?>