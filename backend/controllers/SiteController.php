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

        //array_push($relevadores, "Piwi", "Nico", "Diego", "Matias");
        //array_push($porcentaje, 88, 20, 93, 81);
        // $productos = $query->queryAll();



        $idstore='0';
        $nomstore='';
        $nombrecomercio = '';
        $query2 = $connection->createCommand("SELECT id as idstor, nombre as storename FROM comercios ORDER BY id");
        $result2 = $query2->queryAll();
        foreach ($result2 as $data2){
            if (!empty($data2)){
                if($idstore=='0'){
                    $idstore=$data2['idstor'];
                }
                $nombrecomercio=$nombrecomercio . "<option value='". $data2['idstor'] ."'>". $data2['storename'] ."</option>";
            }
        }
        //$nombrecomercio=$nombrecomercio . "<option value='". $idstore ."'>". $nomstore ."</option>";

        if(isset($_GET['storePicker'])){
            if($_GET['storePicker']!='' && $_GET['storePicker']!='0'){
                $shopId=$_GET['storePicker'];
            }else{
                $shopId = $idstore; //Conseguir id de comercio segun order id!!
            }   
        }else{
            $shopId = $idstore; //Conseguir id de comercio segun order id!!
        }

        $fecha = date('d-m-Y');
        $dateStart = strtotime ( '-8 day' , strtotime ( $fecha ) ) ;
        $dateStart = date ( 'd-m-Y' , $dateStart );
        $dateEnd = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $dateEnd = date ( 'd-m-Y' , $dateEnd );
        $productos=array();
        $pedidos=array();
    if(isset($_GET['startDate']) && isset($_GET['endDate'])){
        if($_GET['startDate']!='' && $_GET['endDate']!=''){
            $dateStart=$_GET['startDate'];
            $dateEnd=$_GET['endDate'];
        }
    }


        //Get productos
        $query3 = $connection->createCommand("SELECT p.nombre as nombre, sum(sp.pedido) AS pedido FROM (comercios c JOIN stock_pedido sp ON c.id=sp.idcomercio) JOIN productos p ON sp.idproducto=p.id WHERE c.id=". $shopId ." AND fecha between str_to_date('".$dateStart ." 00:00:00','%d-%m-%Y %H:%i:%s') and str_to_date('". $dateEnd ." 23:59:59','%d-%m-%Y %H:%i:%s') group by p.nombre");
        $result3 = $query3->queryAll();
        foreach ($result3 as $data3){
            if (!empty($data3)){

                $intpedid=(int)$data3['pedido'];
                array_push($productos, $data3['nombre']);
                array_push($pedidos, $intpedid);
            }
        }

        //array_push($productos, "Banana", "Manzana", "Pera", "Naranja");
        //array_push($pedidos, 150, 100, 130, 80);


        $query4 = $connection->createCommand("SELECT nombre FROM comercios WHERE id=". $shopId);
        $result4 = $query4->queryAll();
        foreach ($result4 as $data4){
            if (!empty($data4)){
                $nomstore=$data4['nombre'];
            }
        }

    

            return $this->render('index', [
                'users' => $relevadores,
                'percent' => $porcentaje,
                'stores' => $nombrecomercio,
                'datei' => $dateStart,
                'datef' => $dateEnd,
                'prods' => $productos,
                'pedi' => $pedidos,
                'nomstor'=>$nomstore,
            ]);


        
    }
/*
    public function actionstoreReport($id, $startdate, $enddate){
        
        //Define connection
        $connection = \Yii::$app->db;

        //Get shop id
        
        $shopId = '1'; //Conseguir id de comercio segun order id!!


        $fecha = date('d-m-Y');
        $dateStart = strtotime ( '-8 day' , strtotime ( $fecha ) ) ;
        $dateStart = date ( 'd-m-Y' , $dateStart );
        //$dateStart = '25/11/2015';
        //$dateEnd = '25/11/2015';
        $dateEnd = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $dateEnd = date ( 'd-m-Y' , $dateEnd );
        $productos=array();
        $pedidos=array();

        //Get productos
        $query3 = $connection->createCommand("SELECT p.nombre as nombre, count(sp.pedido) AS pedido FROM (comercios c JOIN stock_pedido sp ON c.id=sp.idcomercio) JOIN productos p ON sp.idproducto=p.id WHERE c.id=". $shopId ." AND fecha between str_to_date('".$dateStart ." 00:00:00','%d-%m-%Y %H:%i:%s') and str_to_date('". $dateEnd ." 23:59:59','%d-%m-%Y %H:%i:%s') group by p.nombre");
        $result3 = $query3->queryAll();
        foreach ($result3 as $data3){
            if (!empty($data3)){

                $intpedid=(int)$data3['pedido'];
                array_push($productos, $data3['nombre']);
                array_push($pedidos, $intpedid);
            }
        }

        array_push($productos, "Banana", "Manzana", "Pera", "Naranja");
        array_push($pedidos, 150, 100, 130, 80);

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

    public function actionChangedirection()
    {
        return $this->render('changedirection');
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

    public function actionHistory()
    {
        //Get ordenes
        $connection = \Yii::$app->db;
        $query = $connection->createCommand('SELECT r.id as rutaId, r.fecha as fecha, c.nombre as nombreComercio, rr.idrelevador as relevadorId FROM ruta r JOIN ruta_relevador rr ON r.id = rr.idruta JOIN comercios c ON r.idcomercio = c.id WHERE r.relevado = 1');
        $relevamientos = $query->queryAll();

        return $this->render('history', [
            'relevamientos' => $relevamientos
        ]);
    }
}
