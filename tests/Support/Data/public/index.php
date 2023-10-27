<?php

declare(strict_types=1);

use Yiisoft\Config\Config;
use Yiisoft\Config\ConfigPaths;
use Yiisoft\Config\Modifier\RecursiveMerge;

defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'tests');

// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

$rootDir = dirname(__DIR__, 4);

require "$rootDir/c3.php";
require "$rootDir/vendor/autoload.php";
require "$rootDir/vendor/yiisoft/yii2/Yii.php";

$config = new Config(
    new ConfigPaths($rootDir, 'config', 'vendor'),
    'tests',
    [RecursiveMerge::groups('web', 'params-web')],
    'params-web',
);

(new yii\web\Application($config->get('web')))->run();
