<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            //'loginUrl' => null,
        ],
        'request' => [
            // Enable JSON Input:
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                    
                    'HEAD <apiv:v\d+>/<controller:\w+>'              => '<apiv>/<controller>/index',
                    'GET <apiv:v\d+>/<controller:\w+>'               => '<apiv>/<controller>/index',
                    'HEAD <apiv:v\d+>/<controller:\w+>/<id:(.)+>'    => '<apiv>/<controller>/view',
                    'GET <apiv:v\d+>/<controller:\w+>/<action:\w+>/<id:(.)+>'     => '<apiv>/<controller>/view',
                    'GET <apiv:v\d+>/<controller:\w+>/<action:\w+>'  => '<apiv>/<controller>/<action>',
                    'POST <apiv:v\d+>/<controller:\w+>/<action:\w+>/<id:(.)+>'    => '<apiv>/<controller>/create',
                    'POST <apiv:v\d+>/<controller:\w+>/<action:\w+>'  => '<apiv>/<controller>/<action>', 
                    'PUT <apiv:v\d+>/<controller:\w+>/<id:(.)+>'     => '<apiv>/<controller>/update',
                    'PATCH <apiv:v\d+>/<controller:\w+>/<id:(.)+>'   => '<apiv>/<controller>/update',
                    'DELETE <apiv:v\d+>/<controller:\w+>/<id:(.)+>'  => '<apiv>/<controller>/delete',                
            ]       
        ]
    ],
    'params' => $params,
];



