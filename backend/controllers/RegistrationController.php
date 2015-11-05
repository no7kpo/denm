<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\controllers;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;

use dektrium\user\Finder;
use dektrium\user\models\RegistrationForm;
use dektrium\user\models\ResendForm;
use dektrium\user\models\User;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\models\UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RegistrationController is responsible for all registration process, which includes registration of a new account,
 * resending confirmation tokens, email confirmation and registration via social networks.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RegistrationController extends BaseRegistrationController
{

    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise redirects to home page.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** @var RegistrationForm $model */
        $model = Yii::createObject(RegistrationForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            if($model->username == "admin"){
                $UserSearch = Yii::createObject(UserSearch::className());
                $users = $UserSearch->search(['username', 'admin'])->getModels();
                $user = $users[0];
                
                //buscar el codigo del token por consulta
                $query = Yii::$app->db
                        ->createCommand('SELECT code FROM token WHERE user_id = ' . $user->id)
                        ->queryOne();
                $code = $query['code'];
                return $this->confirm($user->id, $code); 
            } else{
                /*return $this->render('/message', [
                    'title'  => Yii::t('user', 'Your account has been created'),
                    'module' => $this->module,
                ]);*/
                Yii::$app->session->setFlash('type-message', 'text-success');
                Yii::$app->session->setFlash('message', Yii::t('user', 'Your account has been created'));
                return $this->redirect(["/user/login"]);    
            }
        }

        return $this->render('register', [
            'model'  => $model, 
            'module' => $this->module,
        ]);
    }

    /**
     * Confirms user's account. If confirmation was successful logs the user and shows success message. Otherwise
     * shows error message.
     *
     * @param int    $id
     * @param string $code
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    private function confirm($id, $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        $user->attemptConfirmation($code);

        return $this->redirect(["/user/login"]);
    }
}