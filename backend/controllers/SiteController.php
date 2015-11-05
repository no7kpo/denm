<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use dektrium\user\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
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
                        'roles' => ['?']
                    ],
                    [
                        //'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback'  => function ($rule, $action) {
                    if(!\Yii::$app->user->isGuest){
                        $User = User::findIdentity(Yii::$app->user->getId());
                        if($User->getIsAdmin()){
                            return $this->redirect(["/user/admin"]);
                        }
                        else{
                            Yii::$app->user->logout();
                            Yii::$app->session->setFlash('type-message', 'text-danger');
                            Yii::$app->session->setFlash('message', 'You don\'t have admin permission');    
                        }
                        
                    }
                        return $this->redirect(["user/login"]);
                    
                },
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /*public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }*/

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    /*
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }*/
}
