<?php
namespace backend\controllers;

use common\models\Resume;
use common\models\User;
use common\models\Vacancy;
use dektrium\user\models\UserSearch;
use dektrium\user\traits\EventTrait;
use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    use EventTrait;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'users', 'export', 'users-with-vacancies', 'users-with-resumes', 'users-with-resumes-and-vacancies', 'not-active-users'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionUsers($id)
    {
        Url::remember('', 'actions-redirect');
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }
        $user->scenario = 'update';
        $event = $this->getUserEvent($user);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Account details have been updated'));
            return $this->refresh();
        }

        return $this->render('users', [
            'user' => $user,
        ]);
    }

    protected function performAjaxValidation($model)
    {
        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax) {
            if ($model->load(\Yii::$app->request->post())) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                \Yii::$app->response->data = json_encode(ActiveForm::validate($model));
                \Yii::$app->end();
            }
        }
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionExport()
    {
        return $this->render('export');
    }

    public function exportFile ($file) {
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        header("Content-Type: text/plain");
        readfile($file);
    }

    public function actionUsersWithVacancies()
    {
        $file = "Users with vacancies.csv";
        $txt = fopen($file, "w") or die("Unable to open file!");
        foreach (User::find()->each() as $user) {
            if(Vacancy::find()->where(['owner'=>$user->id])->count()) {
                fwrite($txt, "$user->email\n");
            }
        }
        fclose($txt);

        $this->exportFile($file);
        unlink("Users with vacancies.csv");

    }

    public function actionUsersWithResumes()
    {
        $file = "Users with resumes.csv";
        $txt = fopen($file, "w") or die("Unable to open file!");
        foreach (User::find()->each() as $user) {
            if(Resume::find()->where(['owner'=>$user->id])->count()) {
                fwrite($txt, "$user->email\n");
            }
        }
        fclose($txt);

        $this->exportFile($file);
        unlink("Users with resumes.csv");

    }

    public function actionUsersWithResumesAndVacancies()
    {
        $file = "Users with resumes and vacancies.csv";
        $txt = fopen($file, "w") or die("Unable to open file!");
        foreach (User::find()->each() as $user) {
            if(Resume::find()->where(['owner'=>$user->id])->count() && Vacancy::find()->where(['owner'=>$user->id])->count()) {
                fwrite($txt, "$user->email\n");
            }
        }
        fclose($txt);

        $this->exportFile($file);
        unlink("Users with resumes and vacancies.csv");

    }

    public function actionNotActiveUsers()
    {
        $file = "Not active users.csv";
        $txt = fopen($file, "w") or die("Unable to open file!");
        foreach (User::find()->each() as $user) {
            if(!Resume::find()->where(['owner'=>$user->id])->count() && !Vacancy::find()->where(['owner'=>$user->id])->count()) {
                fwrite($txt, "$user->email\n");
            }
        }
        fclose($txt);

        $this->exportFile($file);
        unlink("Not active users.csv");

    }
}
