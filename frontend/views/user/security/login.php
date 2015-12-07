<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dektrium\user\widgets\Connect;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<link rel="stylesheet" href="/css/login.css" type="text/css"/>
<div class="col-lg-6">
    <div class="login-box  site-login">
        <div class="login-logo">
            <img src="<?=Url::to('/assets/images/logo.png')?>"/>
            <!--<a href="#"><b>Relevando</b>Frontend</a>-->
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg"><?=Yii::t('app','Sign in to start your session')?></p>
            <p class="login-box-msg <?=Yii::$app->session->getFlash("type-message"); ?>">
                <?= Yii::$app->session->getFlash('message'); ?>
            </p>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

            <?= $form
                ->field($model, 'login', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

            <?= $form
                ->field($model, 'password', $fieldOptions2)
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

            <div class="row">
                <div class="col-xs-8">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                </div>
                <!-- /.col -->
            </div>


            <?php ActiveForm::end(); ?>

            <!--
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                    using Facebook</a>
                <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                    in using Google+</a>
            </div>
            <!-- /.social-auth-links -->
            
            <!--<a href="register" class="text-center">Register a new membership</a>-->

            <?php if ($module->enableRegistration): ?>
                <div class="social-auth-links text-center">
                    <center>
                        <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
                    </center>
                    </br>
                    <center>
                        - <?=Yii::t('app','Or you can')?> -
                    </center>
                    </br>
                    <a href="/user/security/auth?authclient=google" class="btn btn-block btn-social btn-google btn-flat">
                        <i class="fa fa-google-plus"></i> <?=Yii::t('app', 'Sign in using Google+')?>
                    </a>

                </div>  
            <?php endif ?>
            

        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
</div>