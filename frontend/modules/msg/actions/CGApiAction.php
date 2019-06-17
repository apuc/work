<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 12.06.19
 * Time: 17:32
 */

namespace frontend\modules\msg\actions;


use common\classes\Debug;
use frontend\modules\msg\components\CGApiMessages;
use frontend\modules\msg\components\CGMessages;
use vision\messages\actions\MessageApiAction;

/**
 * Class CGApiAction
 * @package frontend\modules\msg\actions
 * @property $subject_id
 * @property $subject_type
 */
class CGApiAction extends MessageApiAction
{
    protected $offset;
    protected $limit;
    protected $subject_id;
    protected $subject_type;

    /**
     *
     */
    public function init()
    {
        $method = \Yii::$app->request->isPost ? "post" :  "get";

        $request = \Yii::$app->request;
        $this->action  = $request->$method('action', 'undefined');
        $this->whom_id = $request->$method('whom_id', false);
        $this->isEmail = $request->$method('isEmail', false);
        $this->message = $request->$method('text', false);
        $this->from_id = $request->$method('from_id', false);
        $this->limit = $request->$method('limit',false);
        $this->offset = $request->$method('offset',false);
        $this->subject_id = $request->$method('subject_id', null);
        $this->subject_type = $request->$method('subject_type',null);
    }

    protected function getMessage() {
        $mess = new CGApiMessages();
        $data['messages'] = $this->getMessageComponent();
        $mess->loadParams([
            'subject_id' => $this->subject_id,
            'subject_type' => $this->subject_type,
        ]);
        $data['messages'] = $mess->getMessages(\Yii::$app->user->getId(), $this->from_id, $this->limit, $this->offset);
        $data['from_id'] = $this->from_id;
        return $data;
    }

    protected function sendMessage() {
        $mess = new CGApiMessages();
        $mess->loadParams([
            'subject_id' => $this->subject_id,
            'subject_type' => $this->subject_type,
        ]);
        if(!$this->whom_id && !$this->message) {
            return ['status' => false, 'message' => 'No data.'];
        }

        $mess->sendMessage($this->whom_id, $this->message, $this->isEmail == 'true');
        $data['messages'] = $mess->getNewMessages($this->getMyId(), $this->whom_id);
        $data['from_id'] = $this->whom_id;
        return $data;
    }

    protected function getMessageComponent()
    {
        return new CGApiMessages();
    }


}