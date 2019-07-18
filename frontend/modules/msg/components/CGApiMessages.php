<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 13.06.19
 * Time: 9:31
 */

namespace frontend\modules\msg\components;


use common\classes\Debug;
use frontend\modules\msg\models\CGMessage;
use vision\messages\components\MyMessages;
use vision\messages\models\Messages;
use yii\db\Query;
use yii\helpers\Html;

class CGApiMessages extends MyMessages
{
    protected $subject_id;
    protected $subject_type;

    /**
     * Method to getMessages.
     *
     * @param $whom_id
     * @param $from_id
     * @param $last_id
     * @param $type
     *
     * @throws ExceptionMessages
     * @return array
     */
    public function getMessages($whom_id, $from_id = null, $limit = null, $offset = null,
                                $type = null, $last_id = null) {
        $table_name = Messages::tableName();
        $my_id = $this->getIdCurrentUser();
        $query = (new Query())
            ->select([
                'msg.created_at',
                'msg.id',
                'msg.status',
                'msg.message',
                'from_id'   => 'usr1.id',
                'from_name' => "usr1.{$this->attributeNameUser}",
                'whom_id'   => 'usr2.id',
                'whom_name' => "usr2.{$this->attributeNameUser}",
                'msg.subject_id',
                'msg.subject_type'
            ])
            ->from(['msg' => $table_name])
            ->leftJoin(['usr1' => $this->userTableName], 'usr1.id = msg.from_id')
            ->leftJoin(['usr2' => $this->userTableName], 'usr2.id = msg.whom_id')
            ->limit($limit)
            ->offset($offset);

        if($from_id) {
            $query
                ->where(['msg.whom_id' => $whom_id, 'msg.from_id' => $from_id])
                ->orWhere(['msg.from_id' => $whom_id, 'msg.whom_id' => $from_id]);
        } else {
            $query->where(['msg.whom_id' => $whom_id]);
        }


        //if not set type
        //send all message where no delete
        if($type) {
            $query->andWhere(['=', 'msg.status', $type]);
        } else {
            /*
            $query->andWhere('((msg.is_delete_from != 1 AND from_id = :my_id) OR (msg.is_delete_whom != 1 AND whom_id = :my_id) ) ', [
                ':my_id' => $my_id,
            ]);
            */
        }

        $query->andWhere('((msg.is_delete_from != 1 AND from_id = :my_id) OR (msg.is_delete_whom != 1 AND whom_id = :my_id) ) ', [
            ':my_id' => $my_id,
        ]);

        if($last_id){
            $query->andWhere(['>', 'msg.id', $last_id]);
        }

        if(empty($this->subject_id))
        {
            $query->andFilterWhere(['is', 'subject_id', new \yii\db\Expression('null')]);
        } else {
            $query->andFilterWhere(['subject_id' => $this->subject_id]);
        }
        if(empty($this->subject_type))
        {
            $query->andWhere(['subject_type' => 'none']);
        } else {
            $query->andFilterWhere(['subject_type' => $this->subject_type]);
        }

        $return = $query->orderBy('msg.id')->all();
//        var_dump($this->subject_id);
//        die();
        $ids = [];
        foreach($return as $m) {
            if($m['whom_id'] == $my_id) {
                $ids[] = $m['id'];
            }
        }
        //change status to is_read
        if(count($ids) > 0) {
            Messages::updateAll(['status' => Messages::STATUS_READ], ['in', 'id', $ids]);
        }

        $user_id = $this->getIdCurrentUser();
        return array_map(function ($r) use ($user_id) {
            $r['i_am_sender'] = $r['from_id'] == $user_id;
            $r['created_at'] = \DateTime::createFromFormat('U', $r['created_at'])->format('d-m-Y H-i-s');
            return $r;
        },
            $return
        );
    }

    public function getAllMessages($whom_id, $from_id) {
        return $this->getMessages($whom_id, $from_id);
    }

    protected function _sendMessage($whom_id, $message, $send_email = false) {
        $model = new CGMessage();
        $model->from_id = $this->getIdCurrentUser();
        $model->whom_id = $whom_id;
        $model->message = Html::encode($message);
        $model->subject_id = $this->subject_id;
        $model->subject_type = empty($this->subject_type) ? 'none' : $this->subject_type ;
        if($this->enableEmail && $send_email) {
            $this->_sendEmail($whom_id, $message);
        }

        return $this->saveData($model, self::EVENT_SEND);
    }

    public function loadParams($data = [])
    {
        $this->subject_id =  isset($data['subject_id']) ? $data['subject_id'] : null;
        $this->subject_type =  isset($data['subject_type']) ? $data['subject_type'] : null;

        return $this;
    }

    public function getNewMessages($whom_id, $from_id) {
        return $this->getMessages($whom_id, $from_id);
    }


}