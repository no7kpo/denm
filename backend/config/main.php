<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name'=>'Relevadores',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'user' => [
            // following line will restrict access to admin page
            //'as backend' => 'dektrium\user\filters\BackendFilter',
            'admins' => ['admin'],
            'controllerMap' => [
                'registration' => 'backend\controllers\RegistrationController'
            ],
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\Module',
        ],
    ],
    'components' => [
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],*/
        'user' => [
            'identityClass' => 'dektrium\user\models\User',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
        // Disable index.php
        'showScriptName' => false,
        // Disable r= routes
        'enablePrettyUrl' => true,
        ],
        'view' => [
         'theme' => [
             'pathMap' => [
                '@dektrium/user/views' => '@app/views/user'
                //'@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],
    ],
    'params' => $params,
];
