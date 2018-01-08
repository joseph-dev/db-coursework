<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('APP_MODE') or define('APP_MODE', 'modern');
// value of APP_MODE can be legacy or modern

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

// Run migration
$config = require __DIR__ . '/../config/console.php';
new \yii\console\Application($config);
\Yii::$app->runAction('migrate/up', ['interactive' => false]);

// Run basic web application
$config = require __DIR__ . '/../config/web.php';
(new yii\web\Application($config))->run();