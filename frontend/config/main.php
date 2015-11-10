<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'user' => [
            // following line will restrict access to admin page
            'as frontend' => 'dektrium\user\filters\FrontendFilter',
            'controllerMap' => [
                'registration' => 'frontend\controllers\RegistrationController'
            ],
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\Module',
        ],
    ],
    'components' => [
        'authClientCollection' => [
                'class' => 'yii\authclient\Collection',
                'clients' => [
                      'google' => [
                          'class' => 'yii\authclient\clients\GoogleOpenId'
                        ],
                        'twitter' => [
                                  'class' => 'yii\authclient\clients\Twitter',
                                  'consumerKey' => 'wXTfoo2TwPmqs6iOrn3SsbPYI',
                                  'consumerSecret' => 'iEKIl5SZdAahAI0x75JEnPJ5Ijcg2Pye3eRYlebCZTP14EtWoL',
                              ],
                    ],
                ],
        
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,*/
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
