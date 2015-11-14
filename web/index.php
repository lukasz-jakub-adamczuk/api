<?php
date_default_timezone_set('Europe/Warsaw');
setlocale(LC_ALL, 'pl_PL.UTF8');



require_once __DIR__ . '/../vendor/autoload.php';

use Squarezone\Api\NewsControllerProvider;
use Squarezone\Api\ArticlesControllerProvider;


$app = new Silex\Application();

$app['debug'] = true;

// load config
if ($_SERVER['HTTP_HOST'] == 'api.squarezone.pl') {
	error_reporting(0);
	require_once '../config/production.php';
	$app['host'] = 'http://api.squarezone.pl/web';
} else {
	if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '192.168.1.108') {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		require_once '../config/local.php';
		$app['host'] = 'http://localhost/~ash/api/web';
	}
}


$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
	'db.options' => $config
));

$app->mount('', new NewsControllerProvider());
$app->mount('', new ArticlesControllerProvider());


$app->get('/', function() use ($app) {
	$url = $app['host'] . '/index.php';

	$api = array(
		'links' => array(
			array(
				'rel' => 'news',
				'href' => $url . '/news'
			),
			array(
				'rel' => 'articles',
				'href' => $url . '/articles'
			)
		),
	);

	return json_encode($api);
});

// $app->before(function (Request $req) {
//     $token = $req->headers->get('token');

//     if ($token != NewsControllerProvider::TOKEN) {
//         throw new \Exception('Incorrect token', 403);
//     }
// });

try {
	$app->run();
} catch(\Exception $e) {
	echo json_encode(['message' => $e->getMessage()]);
}
