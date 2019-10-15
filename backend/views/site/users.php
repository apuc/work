<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */
?>

<?php $this->beginContent('@backend/views/site/update.php', ['user' => $user]) ?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-9',
        ],
    ],
]); ?>
<?php
$token = \dektrium\user\models\Token::findOne(['user_id'=>$user->id]);
if($token): ?>
Ссылка для подтверждения: <?=Url::base(true)?>/confirm/<?=$user->id?>/<?=$token->code?><br><br>
<?php endif ?>
<?= $this->render('@dektrium/user/views/admin/_user', ['form' => $form, 'user' => $user]) ?>

<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
        <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
