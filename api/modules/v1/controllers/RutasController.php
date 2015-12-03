<?php
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use filsh\yii2\oauth2server\filters\auth\CompositeAuth;


class RutasController extends ActiveController
{
	public $modelClass = "common\models\Ruta";

	public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    ['class' => HttpBearerAuth::className()],
                    ['class' => QueryParamAuth::className(), 'tokenParam' => 'accessToken'],
                ]
            ],
            'exceptionFilter' => [
                'class' => ErrorToExceptionFilter::className()
            ],
        ]);
    }

    // public function actions()
    // {
    //     $actions = parent::actions();
    //     unset($actions['view']);
    //     return $actions;
    // }

    public function actionList(){
		if(isset($_GET['id_relevador'])){
			$id = $_GET['id_relevador'];
			$day = date('w') - 1; //A Diego se le ocurrio que el 0 sea el Lunes en vez del Domingo
            $rutas = (new \yii\db\Query())
                    ->select(['idruta', 'idcomercio', 'relevado', 'dia', 'activa', 'fecha', 'latitud', 'longitud'])
                    ->from('ruta')
                    ->innerJoin('ruta_relevador', 'ruta_relevador.idruta = ruta.id')
                    ->innerJoin('user', 'idrelevador = user.id')
                    ->where(['dia' => $day, 'idrelevador' => $id, 'activa' => 1])
                    ->all();
            return $rutas;
    	}else{
            return 'id_relevador is not set';
        }
    }
}