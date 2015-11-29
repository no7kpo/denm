<?php

namespace backend\controllers;

use Yii;
use common\models\Ruta;
use common\models\RutaRelevador;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * RutaController implements the CRUD actions for Ruta model.
 */
class RutaController extends Controller
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
     * Lists all Ruta models.
     * @return mixed
     */
    public function actionIndex()
    {
                    $connection = \Yii::$app->db;
            $sql = $connection->createCommand('SELECT DISTINCT r.id as id,r.dia as dia ,rr.idrelevador as idrelevador FROM ruta r JOIN ruta_relevador rr on r.id=rr.idruta WHERE activa=1 ');
            $modelo =$sql->queryAll(); 
            $dataProvider = new ArrayDataProvider([
        'key'=>'id',
        'allModels' => $modelo,
        'sort' => [
            'attributes' => ['id', 'dia', 'idrelevador'],
        ],
]);    
     /*   $dataProvider = new ActiveDataProvider([
            'query' => Ruta::find(),
        ]);*/

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ruta model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ruta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ruta();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $connection = \Yii::$app->db;
            $sql = 'SELECT * FROM user WHERE id in (Select user_id FROM auth_assignment WHERE item_name = "relevador")';
            $modelo = \common\models\User::findBySql($sql)->all(); 
            $dataUsuarios=ArrayHelper::map($modelo, 'id', 'username');
            $rutarel= new RutaRelevador();
            return $this->render('create', [
                'model' => $model,'users' => $dataUsuarios,'rutarel' =>$rutarel
            ]);
        }
    }

    public function actionGenerarruta()
    {
        $model = new Ruta();
        $rutarelevador= new RutaRelevador();

        $request= Yii::$app->request;
        $comercios=$request->post('datos');
        $model->dia=$request->post('dia');
        $user= \common\models\User::find()->where(['id' => $request->post('relevador')])->one();
         $max = Ruta::find()->max('id');
         $idruta=$max+1;
          $connection = \Yii::$app->db;
          foreach($comercios as $comercio){
          //  var_dump($comercio);
          //  die;
            $connection->createCommand()->insert('ruta',[
                'id'=>$idruta,
                'idcomercio'=>$comercio['id'],
                'relevado' => 0,
                'dia' => $model->dia,
                'activo' => 1
            ])->execute();
          }
          $connection->createCommand()->insert('ruta_relevador',[
            'idruta' => $idruta,
            'idrelevador' => $user->id
            ])->execute();
          return $this->goHome();
          
/*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
           
            $sql = 'SELECT * FROM user WHERE id in (Select user_id FROM auth_assignment WHERE item_name = "relevador")';
            $modelo = \common\models\User::findBySql($sql)->all(); 
            $dataUsuarios=ArrayHelper::map($modelo, 'id', 'username');
            $rutarel= new RutaRelevador();
            return $this->render('create', [
                'model' => $model,'users' => $dataUsuarios,'rutarel' =>$rutarel
            ]);
        }*/
    }

    /**
     * Updates an existing Ruta model.
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

    /**
     * Deletes an existing Ruta model.
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
     * Finds the Ruta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Ruta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ruta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
