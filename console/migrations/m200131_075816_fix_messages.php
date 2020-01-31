<?php

use yii\db\Migration;

/**
 * Class m200131_075816_fix_messages
 */
class m200131_075816_fix_messages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /** @var \common\models\Message $message */
        foreach (\common\models\Message::find()->each() as $message) {
            $deleted = false;
            if($message->subject === 'Vacancy') {
                if(!\common\models\Vacancy::findOne($message->subject_id) && !$deleted) {
                    $message->delete();
                }
            }
            if($message->subject === 'Resume') {
                if(!\common\models\Resume::findOne($message->subject_id) && !$deleted) {
                    $message->delete();
                }
            }
            if($message->subject_from === 'Vacancy') {
                if(!\common\models\Vacancy::findOne($message->subject_from_id) && !$deleted) {
                    $message->delete();
                }
            }
            if($message->subject_from === 'Resume') {
                if(!\common\models\Resume::findOne($message->subject_from_id) && !$deleted) {
                    $message->delete();
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
