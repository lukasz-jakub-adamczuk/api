<?php

require_once __DIR__ . '../app/bootstrap.php';

use Squarezone\Api\OAuth2ControllerProvider;

use Squarezone\Api\NewsControllerProvider;
use Squarezone\Api\ArticlesControllerProvider;
use Squarezone\Api\ArticlesCategoriesControllerProvider;

$app->mount('/oauth2', new OAuth2ControllerProvider());

$app->mount('', new NewsControllerProvider());
$app->mount('', new ArticlesControllerProvider());
$app->mount('', new ArticlesCategoriesControllerProvider());


$app->get('/', function() use ($app) {
	$url = $app['host'] . '/index.php';

	$api = array(
		'links' => array(
			array(
				'rel' => 'news',
				'href' => $url . '/news'
			),
			array(
				'rel' => 'articles-categories',
				'href' => $url . '/articles-categories'
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
