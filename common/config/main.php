<?php
//Alias para poder mostrar imágenes de productos en toda la aplicación
Yii::setAlias('@product_pictures','http://localhost/relevando/backend/imagenes/productos');
return [
	'language' =>'en-US', 

    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            // you will configure your module inside this file
	        // or if need different configuration for frontend and backend you may
	        // configure in needed configs
            'admins' => ['admin'],
            'modelMap' => [
                'LoginForm' => 'common\models\LoginForm',
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
             'translations' => [
                 '*' => [
                 'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
    ],
];
