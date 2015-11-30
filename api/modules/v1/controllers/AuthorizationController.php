<?php
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class AuthorizationController extends ActiveController
{
	public $modelClass = "";

	public function actionLogin()
	{
		return SecurityController::actionLogin();
	}
}