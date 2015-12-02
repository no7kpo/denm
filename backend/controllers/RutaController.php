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
use backend\models\Comercios;
use common\models\User;

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
            $sql = $connection->createCommand('SELECT DISTINCT r.id as id,r.dia as dia ,u.username as relevador FROM ruta r JOIN ruta_relevador rr on r.id=rr.idruta JOIN user u on rr.idrelevador=u.id WHERE activa=1 ');
            $modelo =$sql->queryAll(); 
            $dataProvider = new ArrayDataProvider([
        'key'=>'id',
        'allModels' => $modelo,
        'sort' => [
            'attributes' => ['id', 'dia', 'relevador'],
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
        $model=$this->findModel($id);
        $sql = 'SELECT * FROM comercios WHERE id in (Select idcomercio FROM ruta WHERE id='.$id.')';
        $comercios = Comercios::findBySql($sql)->all(); 
         $comerciosarray=ArrayHelper::toArray($comercios, ['id', 'nombre','latitud','longitud']);
        $sql = 'SELECT * FROM User JOIN ruta_relevador ON id=idrelevador WHERE idruta='.$id;
        $user=User::findBySql($sql)->one(); 
        return $this->render('view', [
            'model' => $model, 'comercios' =>json_encode($comerciosarray), 'usuario' => $user
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
                'activa' => 1
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
    public function actionDisable($id)
    {
        $connection = \Yii::$app->db;
        $connection->createCommand('UPDATE ruta SET activa=0 WHERE id='.$id)->execute();
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

    public function actionPordia(){
        $request= Yii::$app->request;
        $dia=$request->post('id');
     //   $comercios=Comercios::find()->where(['dia'=>$dia])->all();
        $sql = 'SELECT * FROM comercios WHERE dia='.$dia.' and id not in (Select idcomercio FROM ruta WHERE activa=1)';
        $modelo = Comercios::findBySql($sql)->all(); 
        $comerciosrecorridos=ArrayHelper::toArray($modelo, ['id', 'nombre','latitud','longitud']);
     //   $comerciosarray=ArrayHelper::toArray($comercios, ['id', 'nombre','latitud','longitud']);
     //   if(isset($comerciosrecorridos) && !empty($comerciosrecorridos) ){
      //      $return = array_diff_key($comerciosarray,$comerciosrecorridos);
            echo json_encode($comerciosrecorridos);
     //   }else{
     //       echo json_encode($comerciosarray);
     //   }
       
    }

    public function actionRelevador(){
        $request= Yii::$app->request;
        $relevadorId=$request->post('id');
        $relevador=User::find()->where(['id'=>$relevadorId])->one();
        $return=ArrayHelper::toArray($relevador, ['id', 'nombre','latitud','longitud']);
        echo json_encode($return);
    }
}
