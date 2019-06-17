<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 11.06.19
 * Time: 15:30
 */

namespace frontend\modules\msg\widgets;


use frontend\modules\msg\assets\CGMessageAssets;
use frontend\modules\msg\components\CGMessages;
use vision\messages\assets\MessageKushalpandyaAssets;
use vision\messages\widgets\PrivateMessageKushalpandyaWidget;
use vision\messages\widgets\PrivateMessageWidget;
use Yii;

class CGMessageWidget extends PrivateMessageKushalpandyaWidget
{
    public $subject_id;
    public $subject_type;
    public $interlocutor;

    protected function getListUsers() {

        $users = CGMessages::getCurrentUsers(\Yii::$app->user->id);
        $request = Yii::$app->request;

        if($this->interlocutor !== null)
        {
            $users = CGMessages::getOneUser(\Yii::$app->user->id, $this->interlocutor);
        }

        $html = '<ul class="list_users message-user-list">';

        foreach($users as $usr) {
            $html .= '<li class="contact" data-user="' . $usr['id'] . '"><a href="#">';
            //$html .= '<span class="user-img"></span>';
            $html .= '<span class="user-title">' . $usr[\Yii::$app->mymessages->attributeNameUser];
            $html .= ' <span id="cnt">';
//            if($usr['cnt_mess']){
//                $html .=  $usr['cnt_mess'];
//            }
            $html .= "</span></span></a></li>";
        }
        $html .= '</ul>';
        return $html;
    }

    protected function assetJS()
    {
        CGMessageAssets::register($this->view);
    }

    protected function getFormInput() {
        $html = '<div class="message-south"><form action="#" class="message-form" method="POST">';
        $html .= '<textarea disabled="true" name="input_message"></textarea>';
        $html .= '<input type="hidden" name="message_id_user" value="">';
        $html .= '<input type="hidden" name="subject_id" value="'.$this->subject_id.'">';
        $html .= '<input type="hidden" name="subject_type" value="'.$this->subject_type.'">';
        $html .= '<button type="submit">' . $this->buttonName . '</button>';
        $html .= \Yii::$app->mymessages->enableEmail ? '<span class="send_mail"><input class="checkbox" id="send_mail" type="checkbox" name="send_mail" value="1"><label for="send_mail">Отправить также на email</label></span>' : '';
        $html .= '</form></div>';
        return $html;
    }
}