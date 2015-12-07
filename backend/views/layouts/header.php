<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                
              
                <!-- User Account: style can be found in dropdown.less -->
                <?php if(Yii::$app->user->isGuest){ ?>
                    
                 <?php   }else{ ?>
                 <li class="dropdown user user-menu">
                   
                        <!-- <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                         --><?= Html::a(
                                    Yii::t('app','Sign out'),
                                    ['/site/logout'],
                                    ['data-method' => 'post']
                                ) ?>
                    
                   
                </li>
                <?php } ?>
                
                <!-- User Account: style can be found in dropdown.less -->
            
            </ul>
        </div>
    </nav>
</header>
