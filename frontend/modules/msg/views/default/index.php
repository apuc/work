<?php
$this->registerJsFile('/js/CGPrivateMessage.js');
?>
<div class="msg-default-index">
<!--    <h1>--><?//= $this->context->action->uniqueId ?><!--</h1>-->
<!--    <p>-->
<!--        This is the view content for action "--><?//= $this->context->action->id ?><!--".-->
<!--        The action belongs to the controller "--><?//= get_class($this->context) ?><!--"-->
<!--        in the "--><?//= $this->context->module->id ?><!--" module.-->
<!--    </p>-->
<!--    <p>-->
<!--        You may customize this page by editing the following file:<br>-->
<!--        <code>--><?//= __FILE__ ?><!--</code>-->
<!--    </p>-->
</div>
<?//= vision\messages\widgets\CloadMessage::widget() ?>
<?= frontend\modules\msg\widgets\CGMessageWidget::widget([
        'interlocutor' => Yii::$app->request->get('user'),
        'subject_id' => Yii::$app->request->get('subject_id'),
        'subject_type' => Yii::$app->request->get('subject_type'),
]) ?>
<?//= vision\messages\wi    dgets\PrivateMessageKushalpandyaWidget::widget() ?>

