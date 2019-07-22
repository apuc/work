<?php
$this->registerJsFile('/js/CGPrivateMessage.js');
?>
<?= frontend\modules\msg\widgets\CGMessageWidget::widget([
        'interlocutor' => Yii::$app->request->get('user'),
        'subject_id' => Yii::$app->request->get('subject_id'),
        'subject_type' => Yii::$app->request->get('subject_type'),
]) ?>
<?//= vision\messages\wi    dgets\PrivateMessageKushalpandyaWidget::widget() ?>

