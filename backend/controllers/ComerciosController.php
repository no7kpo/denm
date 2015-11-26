<?php

namespace backend\controllers;

use Yii;
use backend\models\Comercios;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\ProductoTienda;
use backend\models\Producto;
use yii\helpers\ArrayHelper;
use backend\models\Categorias;
/**
 * ComerciosController implements the CRUD actions for Comercios model.
 */
class ComerciosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Comercios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comercios::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comercios model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $ProductoTiendaModel = new ProductoTienda();
        $ProductosId = $ProductoTiendaModel->getAllProductos($id);
        $Productos = [];
        if($ProductosId != null){
            foreach ($ProductosId as $key => $value) {
                $producto = Producto::find()->where(['id' => $value['idproducto']])->one();
                array_push($Productos, $producto);
            }
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $Productos,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'productos' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Comercios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comercios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Comercios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionAddproducts($id)
    {
        $model = $this->findModel($id);
        
        if (!$model->load(Yii::$app->request->post())) {
            //Obtengo los id de los productos en la tienda $id
            $ProductoTiendaModel = new ProductoTienda();
            $Productos = $ProductoTiendaModel->getAllProductos($id);
            $ProductosId = [];
            foreach ($Productos as $key => $value) {
                array_push($ProductosId, $value['idproducto']);
            }
            //Obtengo todos los productos y los separo en 2 arreglos
            $ProductosEnTienda = [];
            $RestoProductos = [];
            $TodosLosProductos = Producto::find()->all();
            foreach ($TodosLosProductos as $key => $value) {
                if(in_array($value['id'], $ProductosId)) {
                    array_push($ProductosEnTienda, $value);
                } else {
                    array_push($RestoProductos, $value);
                }
            }
            $productos = new ArrayDataProvider([
                'allModels' => $ProductosEnTienda,
            ]);
            $resto = new ArrayDataProvider([
                'allModels' => $RestoProductos,
            ]);
            return $this->render('addProducts', [
                'model' => $model,
                'productos' => $productos,
                'resto' => $resto,
            ]);
        }
    }

    public function actionAdd_product(){
        $ProductoTiendaModel = new ProductoTienda();
        
        if ($ProductoTiendaModel->load(Yii::$app->request->post())) {
            $producto = Producto::find()->where(['id' => $ProductoTiendaModel->idproducto])->one();
            $categoria = Categorias::findOne($producto->idcategoria);
            $ProductoTiendaModel->save();
            $tooltip = Yii::t('app', 'Click to remove');
            $message = ['id' => $producto->id, 
                        'nombre' => $producto->Nombre, 
                        'categoria' => $categoria->nombre,
                        'tooltip' => $tooltip
                        ];
            Yii::$app->response->format = 'json';
            return $message;
        }
    }

    public function actionRemove_product(){
        $ProductoTiendaModel = new ProductoTienda();
        if($ProductoTiendaModel->load(Yii::$app->request->post())){
            $producto = Producto::find()->where(['id' => $ProductoTiendaModel->idproducto])->one();
            $categoria = Categorias::findOne($producto->idcategoria);
            $ProductoTienda = ProductoTienda::find()
                            ->where(['idproducto' => $ProductoTiendaModel->idproducto, 
                                    'idcomercio' => $ProductoTiendaModel->idcomercio])
                            ->one();
            $ProductoTienda->delete();
            $tooltip = Yii::t('app', 'Click to add');
            $message = ['id' => $producto->id, 
                        'nombre' => $producto->Nombre, 
                        'categoria' => $categoria->nombre,
                        'tooltip' => $tooltip
                        ];
            Yii::$app->response->format = 'json';
            return $message;
        }
    }

    public function actionPordia(){
        $request= Yii::$app->request;
        $dia=$request->post('id');
        $comercios=Comercios::find()->where(['dia'=>$dia])->all();
        $return=ArrayHelper::toArray($comercios, ['id', 'nombre','latitud','longitud']);
        
        echo json_encode($return);
    }

    /**
     * Deletes an existing Comercios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Comercios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Comercios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comercios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
