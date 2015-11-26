<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use dektrium\user\models\User;
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
                            Yii::$app->session->setFlash('message', Yii::t('user','You don\'t have admin permission'));    
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

        $connection = \Yii::$app->db;

        //Get shop id
        
        $relevadores=array();
        $porcentaje=array();

        //Get productos
        $query = $connection->createCommand("SELECT u.username as usuario, CAST((((SUM(rute.sirelevada))*100)/(count(rute.id))) as UNSIGNED) as porcentaje from (select r.id, (case r.relevado when 1 then 1 else 0 end) as sirelevada, (case r.relevado when 1 then 0 else 1 end) as norelevada from ruta r) rute, ruta_relevador rr, user u where rute.id=rr.idruta and rr.idrelevador=u.id and u.username<>'admin' group by u.username");
        $result = $query->queryAll();
        foreach ($result as $data){
            if (!empty($data)){

                $intporcent=(int)$data['porcentaje'];
                array_push($relevadores, $data['usuario']);
                array_push($porcentaje, $intporcent);
            }
        }

        array_push($relevadores, "Piwi", "Nico", "Diego", "Matias");
        array_push($porcentaje, 88, 20, 93, 81);
        // $productos = $query->queryAll();

            return $this->render('index', [
                'users' => $relevadores,
                'percent' => $porcentaje,
            ]);


        
    }
/*
    public function actionGetReportStore($id = 0){
        
        //Define connection
        $connection = \Yii::$app->db;

        //Get shop id
        $shopId = '1'; //Conseguir id de comercio segun order id!!

        $dateStart = '2015-11-25';
        $dateEnd = '2015-11-25';
        $productos=array();
        $pedidos=array();

        //Get productos
        $query = $connection->createCommand("SELECT p.nombre as nombre, count(sp.pedido) AS pedido FROM (comercios c JOIN stock_pedido sp ON c.id=sp.idcomercio) JOIN productos p ON sp.idproducto=p.id WHERE c.id=". $shopId ." AND fecha between str_to_date('".$dateStart ." 00:00:00','%Y-%m-%d %H:%i:%s') and str_to_date('". $dateEnd ." 23:59:59','%Y-%m-%d %H:%i:%s') group by p.nombre");
        $result = $query->queryAll();
        foreach ($result as $data)
            if (!empty($data)){
                array_push($productos, $data['nombre']);
                array_push($pedidos, $data['pedido']);
            }
        }

        // $productos = $query->queryAll();

            return $this->render('reportStore', [
                'products' => $productos,
                'request' => $pedidos,
            ]);

        
        // return $this->render('order', [
        //     'orderId' => $orderId,
        //     'shopId' => $shopId,
        //     'productos' => $productos,
        //     'comercio' => $comercio,
        // ]);

    }
*/

    
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
