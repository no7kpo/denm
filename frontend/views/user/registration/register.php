<?php

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
<link rel="stylesheet" href="/css/register.css" type="text/css"/>
<div class="col-lg-6">
    <div class="login-box site-register">
        <!--<div class="col-md-4 col-md-offset-4">-->
            <div class="login-logo">
                <img src="<?=Url::to('/assets/images/logo.png')?>"/>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg"><?= Html::encode($this->title) ?></p>
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
                </br>
                <?php ActiveForm::end(); ?>
                <p class="text-center">
                    <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
                </p>
            </div>
            
        <!--</div><-->
    </div>
</div>
