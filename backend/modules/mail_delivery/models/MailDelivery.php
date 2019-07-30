<?php

namespace backend\modules\mail_delivery\models;

use common\classes\Debug;
use common\models\Company;
use common\models\SendMail;
use common\models\User;
use common\models\Vacancy;
use dektrium\user\models\Token;
use Yii;

class MailDelivery extends SendMail
{
    public $file;
    public $excel;
    public $letter;

    public function rules()
    {
        return [
            [['excel'], 'file', 'extensions' => 'xlsx'],
            [['letter'], 'file', 'extensions' => 'php, html'],
            [['email', 'user_id', 'template', 'subject'], 'required'],
            ['email', 'email'],
            [['user_id', 'status'], 'integer'],
        ];
    }

    public function parseExcel($file)
    {
        $this->readExcel($file);
    }

    public function readExcel($file)
    {
        $objPHPExcel = \PHPExcel_IOFactory::load($file->tempName);
        $count = $objPHPExcel->getSheetCount();

        for ($i = 0; $i < $count; ++$i) {
            $result = [];
            $objPHPExcel->setActiveSheetIndex($i);
            $sheetTitle = $objPHPExcel->getActiveSheet()->getTitle();
            $maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
            $data = $objPHPExcel->getActiveSheet()->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);

            foreach ($data as $row) {
                if ($row[0] != 'Почта' && $row[0] != 'Почты' && !empty($row[0])) {
                    $tmp = [$row[0], $row[1]];
                    array_push($result, $tmp);
                }
            }

            $this->saveMessage($result, $sheetTitle);
            unset($sheetTitle);
            unset($sheet);
            unset($result);
            unset($tmp);
        }
    }

    public function saveMessage($result, $sheetTitle)
    {
        foreach ($result as $item) {
            $model = new SendMail();
            $model->email = $item[0];
            $letter = 'letter2.php';
            $options = [];
            $model->subject = 'Наконец то! Новый сервис работы';
            if (isset($item[4])) {
                $model->subject = $item[4];
            }
            $model->user_id = $this->getUser($model->email);
            if ($sheetTitle == 'Почты вакансии') {
                $options['variable'] = $this->getVacancy($model->user_id);
                $letter = 'letter3.php';
                $model->subject = 'Я тебя давно искал. Твоя вакансия уже у нас!';
            }
            if ($sheetTitle == 'Резюме добавлены' || $sheetTitle == 'Резюме список') {
                $options['variable'] = $this->getToken($model->user_id);
                $letter = 'letter1.php';
                $model->subject = 'Есть работа! Личное приглашение';
            }
            $options['name'] = $item[1] ? $item[1] : '';
            $model->status = 0;
            $model->template = $letter;
            if (!isset($options['variable'])) {
                $options['variable'] = '';
            }
            $model->options = json_encode($options);
            $model->save();
            if (count($result) == 1) {
                return $model->id;
            }
            unset($model);
            unset($options);
            unset($letter);
        }
    }

    public function sendMessage($users, $answer = false)
    {
        $messages = [];
        foreach ($users as $user) {
            $options = (array)json_decode($user->options);
            $messages[] = Yii::$app->mailer->compose('admin_template/' . $user->template, [
                'name' => $options['name'],
                'variable' => $options['variable'],
                'id' => $user->user_id
            ])
                ->setFrom('noreply@rabota.today')
                ->setSubject($user->subject)
                ->setTo($user->email)->send();
            $user->status = 1;
            $user->dt_send = strtotime(date("Y-m-d H:i:s"));
            $user->save();
            if ($answer == true) {
                echo 'Почта отправлена на адрес:' . $user->email . "\n";
            }
            sleep(1);
        }
    }

    public function getUser($email)
    {
        $user = User::findOne(['email' => $email]);
        if (!$user) {
            return null;
        }

        return $user->id;
    }

    public function getToken($id)
    {
        $token = Token::findOne(['user_id' => $id]);
        if (!$token) {
            return '';
        }
        $token = $token ? $token->code : '';

        return $token;
    }

    public function getVacancy($id)
    {
        $company_id = Company::findOne(['user_id' => $id]);
        if (!$company_id) {
            return '';
        }
        $vacancy = Vacancy::findOne(['company_id' => $company_id->id]);

        return $vacancy->id;
    }
}