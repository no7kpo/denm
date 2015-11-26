<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;

class ProductosController extends ActiveController
{
    public $modelClass = 'backend\models\Producto';    

    public function actionHola(){
    	$a = ["a"=>1,
    		  "b"=>2,
    		  "c"=>3,
    		  "d"=>4,
    	];

    	return $a;
    }
	
}


