<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/**
 * @var yii\web\View              $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\Module      $module
 */

$this->title = Yii::t('user', 'Sign up');
//$this->params['breadcrumbs'][] = $this->title;

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions3 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
<link rel="stylesheet" href="/css/login.css" type="text/css"/>
<div class="col-lg-6">
    <div class="login-box site-login">
        <div class="login-logo">
            <img src="<?=Url::to('/assets/images/logo-blanco.png')?>"/>
        </div>
        <div class="login-box-body">
            <p class="panel-title"><?= Html::encode($this->title) ?></p>
            
            <?php $form = ActiveForm::begin([
                'id'                     => 'registration-form',
                'enableAjaxValidation'   => true,
                'enableClientValidation' => false,
            ]); ?>

            <?= $form
                ->field($model, 'username', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

            <?= $form
                ->field($model, 'email', $fieldOptions2)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

            <?php if ($module->enableGeneratingPassword == false): ?>
                <?= $form
                    ->field($model, 'password', $fieldOptions3)
                    ->label(false)
                    ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

            <?php endif ?>

            <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

            <?php ActiveForm::end(); ?>
            <br>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
            </p>
        </div>
    </div>
</div>
