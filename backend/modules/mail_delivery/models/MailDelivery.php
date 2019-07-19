<?php

namespace backend\modules\mail_delivery\models;

use common\classes\Debug;
use common\models\Company;
use common\models\SendMail;
use common\models\User;
use common\models\Vacancy;
use dektrium\user\models\Token;
use Yii;
use yii\base\Model;
use yii\validators\EmailValidator;

class MailDelivery extends Model
{
    public $file;
    public $excel;

    public function rules()
    {
        return [
          [['excel'], 'file', 'extensions' => 'xlsx'],
        ];
    }

    public function parseExcel($file)
    {
        ini_set("memory_limit",-1);
        $validator = new EmailValidator();
        $objPHPExcel = \PHPExcel_IOFactory::load($file->tempName);
        $count = $objPHPExcel->getSheetCount();
        $res = $objPHPExcel->setActiveSheetIndex(1)->getRowIterator();
        Debug::dd($res);

        for($i = 0; $i < $count; ++$i) {
            $result = [];
            $objPHPExcel->setActiveSheetIndex($i);
            $sheet = $objPHPExcel->getActiveSheet();
            $sheetTitle = $sheet->getTitle();

            foreach ($sheet->toArray() as $row) {
                if ($row[0] != 'Почта' && !empty($row[0])) {
                    $tmp = [$row[0], $row[1]];
                    array_push($result, $tmp);
                }
            }
//            $this->saveMessage($result, $sheetTitle);
            unset($sheetTitle);
            unset($sheet);
            unset($result);
            unset($tmp);
        }


    }

    public function saveMessage($result, $sheetTitle)
    {
        foreach ($result as $item)
        {
            $model = new SendMail();
            $model->email = $item[0];
            $letter = 'letter2';
            $options = [];
            $model->user_id = $this->getUser($model->email);
            if($sheetTitle == 'Почты вакансии') {
                $options['token'] = $this->getVacancy($model->user_id);
                $letter = 'letter3';
            }
            if($sheetTitle == 'Резюме добавлены' || $sheetTitle == 'Резюме список') {
                $options['vacancy'] = $this->getToken($model->user_id);
                $letter = 'letter1';
            }
            $options['name'] = $item[1];
            $model->status = 0;
            $model->template = $letter;
            $model->options = json_encode($options);
            $model->save();
            unset($model);
            unset($options);
            unset($letter);
        }
    }

    public function sendMessage($users, $result, $letter)
    {
        $messages = [];
        foreach ($users as $user) {
            foreach ($result as $item) {
                if($user['email'] == $item[0]) {
                    if(!isset($user['variable'])){
                        $user['variable'] = '';
                    }
                    $messages[] = Yii::$app->mailer->compose($letter, [
                        'name' => $item[1],
                        'variable' => $user['variable'],
                        'id'   => $user['id'],
                    ])
                        ->setFrom('noreply@rabota.today')
                        ->setSubject('Тестовая рассылка для сайты с работой')
                        ->setTo($item[0]);
                }
            }
        }
        return Yii::$app->mailer->sendMultiple($messages);
    }

    public function getUsersByEmail($data)
    {
        $forQuery = [];
        foreach ($data as $item)
        {
            array_push($forQuery,$item[0]);
        }
        $result = User::find()->where(['in', 'email', $forQuery])->asArray()->all();

        return $result;
    }

    public function getTokensById($data)
    {
        foreach ($data as &$item){
            $token = Token::findOne(['user_id' => $item['id']]);
            $item['variable'] = $token ? $token->code : '';
        }

        return $data;
    }

    public function getLinkVacancy( $data)
    {
        foreach ($data as &$item) {
            $company_id = Company::findOne(['user_id' => $item['id']]);
            $vacancy = Vacancy::findOne(['company_id' => $company_id]);
            $item['variable'] = $vacancy ? $vacancy->id : '';
        }

        return $data;
    }

    public function getUser($email)
    {
        $user = User::find()->where(['email' => $email])->asArray()->one();
        return $user['id'];

    }

    public function getToken($id)
    {
        return Token::findOne(['user_id' => $id]);
    }

    public function getVacancy($id)
    {
        $company_id = Company::findOne(['user_id' =>$id]);
        return Vacancy::findOne(['company_id' => $company_id]);
    }
}