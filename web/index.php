<?php

require_once __DIR__ . '/../app/bootstrap.php';

use Squarezone\Api\OAuth2ControllerProvider;

use Squarezone\Api\NewsControllerProvider;
use Squarezone\Api\ArticlesControllerProvider;
use Squarezone\Api\ArticlesCategoriesControllerProvider;

use Squarezone\Api\Service\OAuth2Service;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;

// use Squarezone\Exception\SquarezoneException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

// need for accessToken checking
// how to enable this for other than /oauth routes?
$app->before(function (Request $req) use ($app) {
    if ($_SERVER['PATH_INFO'] !== '/oauth2/') {
        $service = new OAuth2Service($app['db']);

        $accessToken = $req->headers->get('access_token', null);

        try {
            $service->isValidAccessToken($accessToken);
        } catch (EmptyAccessTokenException $e) {
            throw new HttpException(403);
        } catch (MissingAccessTokenException $e) {
            throw new HttpException(403);
        } catch (ExpiredAccessTokenException $e) {
            throw new HttpException(403);
        }
    }
});

try {
    $app->run();
} catch(\Exception $e) {
    echo json_encode(['message' => $e->getMessage()]);
}
