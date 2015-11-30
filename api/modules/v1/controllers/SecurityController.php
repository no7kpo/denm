<?php

namespace api\modules\v1\controllers;

use dektrium\user\controllers\SecurityController as BaseSecurityController;

use dektrium\user\Finder;
use dektrium\user\models\Account;
use dektrium\user\models\LoginForm;
use dektrium\user\models\User;
use dektrium\user\Module;
use dektrium\user\traits\AjaxValidationTrait;
use Yii;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class SecurityController extends BaseSecurityController
{
	public function actionLogin()
	{
		if (Yii::$app->user->isGuest) {
        	/** @var LoginForm $model */
	        $model = Yii::createObject(LoginForm::className());

	        //$this->performAjaxValidation($model);
	        if (Yii::$app->getRequest()->post()) {
	        	$post = Yii::$app->getRequest()->post();
	        	$model->login = $post['login'];
	        	$model->password = $post['password'];
	        	$model->rememberMe = $post['rememberMe'];
	        	if ($model->login()) {
	        		return ['access_token' => Yii::$app->user->identity->getAuthKey()];	
	        	}
	        	else{
	        		$model->validate();
	        		return $model;
	        	}
	        }
	        //$model->validate();
	        return $model;
    	}
	}
}