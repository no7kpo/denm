<?php

namespace backend\controllers;

use Yii;
use backend\models\Producto;
use backend\models\UploadForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProductoController implements the CRUD actions for Producto model.
 */
class ProductoController extends Controller
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
     * Lists all Producto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Producto::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Producto model.
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
     * Creates a new Producto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Producto();
        if ($model->load(Yii::$app->request->post())) {
            $foto = new UploadForm();
            $foto->imageFile = UploadedFile::getInstance($foto, 'imageFile');
            $upload_result = $foto->upload();
            if ($upload_result != false) {
                // file is uploaded successfully
                $model->Imagen = $upload_result;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }   //Si no es post o el producto no se guarda correctamente se devuelve el formulario
            $img_model = new UploadForm();
            return $this->render('create', [
                'model' => $model, 'img_model' =>$img_model
            ]);
    }

    /**
     * Updates an existing Producto model.
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

    public function actionUpdate_picture($id){

        $model = $this->findModel($id);
        if($model->load(Yii::$app->request->post())){
            $foto = new UploadForm();
            $foto->imageFile = UploadedFile::getInstance($foto, 'imageFile');
            
            $upload_result = $foto->upload();
            if ($upload_result != false){
                unlink(Yii::getAlias('@backend') . DIRECTORY_SEPARATOR.'imagenes'.DIRECTORY_SEPARATOR.'productos'. DIRECTORY_SEPARATOR . $model->Imagen);
                $model->Imagen = $upload_result;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }   //Método GET o falla subida de imágen
            $img_model = new UploadForm();
            return $this->render('update_picture', [
                'model' => $model, 'img_model' => $img_model,
            ]);
    }

    /**
     * Deletes an existing Producto model.
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
     * Finds the Producto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Producto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Producto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
