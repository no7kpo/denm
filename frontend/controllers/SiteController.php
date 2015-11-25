<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\CreateorderForm;
use yii\db\Query;

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
                //'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['relevador'],
                    ],
                ],
                'denyCallback'  => function ($rule, $action){
                    if(!\Yii::$app->user->isGuest){
                        Yii::$app->user->logout();
                        Yii::$app->session->setFlash('type-message', 'text-danger');
                        Yii::$app->session->setFlash('message', Yii::t('user','You don\'t have permission'));
                    }
                    return $this->redirect(["user/login"]);
                }
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //Define connection
        $connection = \Yii::$app->db;

        $relevadorId = Yii::$app->user->identity->id;
        $fecha = date('Y-m-d');

        //Get ordenes
        $query = $connection->createCommand('SELECT r.id as id, r.relevado as relevado, r.fecha as fecha, r.idcomercio as idComercio, c.nombre as nombre, c.latitud as latitud, c.longitud as longitud, c.prioridad as prioridad, c.hora_apertura as horaAper, c.hora_cierre as horaCierr FROM ruta r JOIN ruta_relevador rr ON r.id = rr.idruta JOIN comercios c ON r.idcomercio = c.id WHERE rr.idrelevador = '.$relevadorId.' AND r.fecha = "'.$fecha.'"');
        $orders = $query->queryAll();

        //echo '<pre>'; print_r($rutas); die();

        return $this->render('index', [
            'orders' => $orders,
        ]);
    }

    public function actionChangedirection()
    {
        return $this->render('changedirection');
    }
    public function actionUpdateaddress()
    {
        $request = Yii::$app->request;
        $latitud=$request->post('latitud');
        $longitud=$request->post('longitud');
        $user = Yii::$app->user->identity;
        $user->latitud=$latitud;
        $user->longitud=$longitud;
        $user->scenario = 'update';
        $user->save();
        return $this->render('index');
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
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
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    public function actionOrder($id = 0){
        
        //Define connection
        $connection = \Yii::$app->db;

        //Get shop id
        $shopId = $_GET['id'];

        $fecha = date('Y-m-d');

        //Get productos
        $query = $connection->createCommand('SELECT sp.idproducto as idproducto, sp.pedido as pedido, p.Nombre as nombre, p.Imagen as imagen FROM stock_pedido sp JOIN productos p ON sp.idproducto = p.id WHERE sp.idcomercio = '.$shopId.' AND sp.fecha = "'.$fecha.'"');
        $productos = $query->queryAll();

        //Get comercio
        $query = $connection->createCommand('SELECT * FROM comercios WHERE id = '.$shopId);
        $comercio = $query->queryOne();

        return $this->render('order', [
            'shopId' => $shopId,
            'fecha' => $fecha,
            'productos' => $productos,
            'comercio' => $comercio,
        ]);

    }

    public function actionSavethisitem(){
        $shopId = $_POST['shopId'];
        $fecha = $_POST['fecha'];
        $itemId = $_POST['itemId'];
        $stock = $_POST['stock'];

        //Define connection
        $connection = \Yii::$app->db;

        $query = $connection->createCommand('UPDATE stock_pedido SET stock = '.$stock.' WHERE idcomercio = '.$shopId.' AND idproducto = '.$itemId.' AND fecha = "'.$fecha.'"');
        $query->execute();

        echo 'UPDATE stock_pedido SET stock = '.$stock.' WHERE idcomercio = '.$shopId.' AND idproducto = '.$itemId.' AND fecha = "'.$fecha.'"';
    }

    public function actionDeliverydone(){
        $shopId = $_POST['shopId'];
        $fecha = $_POST['fecha'];

        //Define connection
        $connection = \Yii::$app->db;

        $query = $connection->createCommand('UPDATE ruta SET relevado = 1 WHERE idcomercio = '.$shopId.' AND fecha = "'.$fecha.'"');
        $query->execute();

        echo 'UPDATE ruta SET relevado = 1 WHERE idcomercio = '.$shopId.' AND fecha = "'.$fecha.'"';
    }

    public function actionNeworder(){
        //Define connection
        $connection = \Yii::$app->db;

        //Get comercios
        $query = $connection->createCommand('SELECT c.id, c.nombre FROM comercios c');
        $comercios = $query->queryAll();

        return $this->render('new_order', [
            'comercios' => $comercios,
        ]);
    }
    

    public function actionCreateorder($id = 0){
        //Define connection
        $connection = \Yii::$app->db;

        $shopId = $_GET['id'];

        //Get comercio
        $query = $connection->createCommand('SELECT c.id, c.nombre, c.hora_apertura, c.hora_cierre FROM comercios c WHERE id = '.$shopId);
        $comercio = $query->queryOne();

        //Get items
        $query = $connection->createCommand('SELECT p.id, p.nombre, p.Imagen FROM productos p JOIN producto_tienda pt ON p.id = pt.idproducto WHERE pt.idcomercio = '.$shopId);
        $items = $query->queryAll();

        //Yii crap
        $model = new CreateorderForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->createorderform($id)) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        
        return $this->render('create_order', [
            'model' => $model,
            'comercio' => $comercio,
            'items' => $items,
        ]);
    }


    public function actionCreateneworder(){
        //Define connection
        $connection = \Yii::$app->db;

        $userId = $_POST['userId'];
        $deliveryDay = $_POST['deliveryDay'];
        $arrayItems = $_POST['arrayItems'];

        //Get comercios
        //$query = $connection->createCommand('SELECT c.id, c.nombre FROM comercios c');
        //$comercios = $query->queryAll();

        print_r($arrayItems);
    }

}
