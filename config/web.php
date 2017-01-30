<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'hello world',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
           //'enableStrictParsing'=> true,
            'baseUrl' => '',
            
            
             'rules' => array(
            '<controller:\w+>/<id:\d+>' => '<controller>/view',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        ),
         'rules' => [
            'index'=>'site/index',
             'admin'=>'admin/admin',
             'login'=>'site/login',
             //добавляем студента без группы через ajax
             'addstudent' => 'site/addstudent',
             //Добавляем группу в базу через ajax
             'addgroup' => 'site/addgroup',
             //Проверяем существует ли такой препод через ajax
             'allteacher' => 'site/allteacher',
             //Выводим данные о группе в index
             'getinfogroup' => 'site/getinfogroup',
             //Вводим данные в journal  с "iншi"
             'inshi' => 'site/inshi',
             //UPDATE таблицу journal
             'updateinfojournal' => 'site/updateinfojournal',
             //INSERT  в таблицу journal
             'insertinfojournal' => 'site/insertinfojournal',
             //Проверяем существует ли такой студент через ajax
             'searchstudent' => 'site/searchstudent',
             
             
             
             
             ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
