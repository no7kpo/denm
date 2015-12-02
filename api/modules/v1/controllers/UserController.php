<?php

namespace api\modules\v1\controllers;

//use filsh\yii2\oauth2server\controllers\RestController as BaseRestController;

use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\authclient\AuthAction;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\authclient\ClientInterface;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use filsh\yii2\oauth2server\filters\auth\CompositeAuth;


class UserController extends ActiveController
{
	public $modelClass = "common\models\User";

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

	public function actionId(){
		if(!Yii::$app->request->post()){
			if(isset($_GET['token'])){
				$access_token = $_GET['token'];
				$user_id = (new \yii\db\Query())
				    ->select('user_id')
				    ->from('oauth_access_tokens')
				    ->where(['access_token' => $access_token])
				    ->all();
				return $user_id;		
			}else{
				return 'No token in GET';
			}
			
		}
		
	}
}

// class RestController extends BaseRestController
// {
// 	public function actionToken()
//     {
//         $response = $this->module->getServer()->handleTokenRequest();
//         $parameters = $response->getParameters();
//         $user_id = (new \yii\db\Query())
// 				    ->select(['user_id'])
// 				    ->from('oauth_access_tokens')
// 				    ->where(['access_token' => $parameters['access_token']])
// 				    ->one();
// 		return [$parameters, $user_id];
//     }
// }