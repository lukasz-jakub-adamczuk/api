<?php

date_default_timezone_set('Europe/Warsaw');
setlocale(LC_ALL, 'pl_PL.UTF8');

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$env = getenv('SQUAREZONE_ENV');

if (!$env) {
    switch ($_SERVER['HTTP_HOST']) {
        case 'api.squarezone.pl':
            $env = 'prod';
            break;

        case 'localhost':
        case '192.168.1.108':
            $env = 'dev';
            break;
    }
}

if ($env == 'prod') {
    error_reporting(0);
    require_once __DIR__ . '/../config/production.php';
    $app['host'] = 'http://api.squarezone.pl/web';
} elseif ($env == 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once __DIR__ . '/../config/local.php';
    $app['host'] = 'http://localhost/~ash/api/web';
}

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $config
));
