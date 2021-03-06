<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\widgets\ActiveForm;
use yii\bootstrap\BootstrapAsset;

if (Yii::$app->controller->action->id === 'login' || 
    Yii::$app->controller->action->id === 'register') {
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else{
    AppAsset::register($this);
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
      #map-canvas {
        width: 500px;
        height: 400px;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js"></script>

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody();
        $this->registerCssFile("/css/layout-main.css", [
            'depends' => [BootstrapAsset::className()],
            ], 'css-print-theme'
        ); 
    ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Html::img('/assets/images/logo-blanco.png', ['alt'=>Yii::$app->name, 'style' => 'max-height:100%;']),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            $menuItems[] = ['label' => 'About Us', 'url' => ['/site/about']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        } else {
            $menuItems[] = [
                'label' => Yii::t('app', Yii::t('app',"Change your address!")),
                'url' => ['/site/changedirection']
            ];
            $menuItems[] = [
                'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>

        <div class="container">
            
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p style="display:inline;">&copy; Taller Php2 <span style="display:inline; float:right;"><?= date('D M Y') ?></span></p>
        </div>
    </footer>

    <?php $this->endBody() ?>

    </body>
    </html>
    <?php $this->endPage();
}
?>
