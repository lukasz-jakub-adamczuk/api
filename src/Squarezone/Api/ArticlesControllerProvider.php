<?php

namespace Squarezone\Api;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Squarezone\Api\Service\ArticleListProvider;
use Squarezone\Api\Service\ArticleProvider;
use Squarezone\Api\Service\ArticleCreator;
use Squarezone\Api\Service\ArticleEditor;
use Squarezone\Api\Service\ArticleRemover;
use Squarezone\Api\Service\OAuth2Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Squarezone\Exception\SquarezoneException;
use Symfony\Component\HttpKernel\Exception\HttpException;


class ArticlesControllerProvider implements ControllerProviderInterface {

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/articles', function(Request $req) use ($app) {
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

            $service = new ArticleListProvider();

            $items = $service->get($req, $app['db']);

            $url = $app['host'] . '/index.php';

            foreach ($items as &$item) {
                $item['links'] = array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/articles/'.$item['category'].'/'.$item['slug']
                    )
                );
            }

            $response = array(
                'links' => array(
                    array(
                        'rel' => 'next',
                        'href' => $url . '/news?page=1&size=25'
                    )
                ),
                'content' => $items,
                'page' => array(
                    'size' => 25,
                    'totalElements' => count($items),
                    'totalPages' => '???',
                    'number' => 0
                )
            );

            return json_encode($response);
        });

        $controllers->get('/articles/{category}', function(Request $req) use ($app) {
            $service = new ArticleListProvider();

            $items = $service->get($req, $app['db']);

            $url = $app['host'] . '/index.php';

            foreach ($items as &$item) {
                $item['links'] = array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/articles/'.$item['category'].'/'.$item['slug']
                    )
                );
            }

            $response = array(
                $items
            );

            return json_encode($response);

        })
        ->assert('category', '[a-z0-9-]+');

        $controllers->get('/articles/{category}/{slug}', function(Request $req) use ($app) {
            $service = new ArticleProvider();

            $item = $service->get($req, $app['db']);

            $url = $app['host'] . '/index.php';

            $response = array(
                'links' => array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/articles/' . $item['category'] . '/' . $item['slug']
                    )
                ),
                'article' => $item
            );

            return json_encode($response);
        })
        ->assert('category', '[a-z0-9-]+')
        ->assert('slug', '[a-z0-9-]+');


        $controllers->post('/articles', function(Request $req) use ($app) {
            $service = new ArticleCreator();

            $fields = $req->request->all();

            $article = $service->create($fields, $app['db']);

            $url = $app['host'] . '/index.php';

            $response = array(
                'links' => array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/articles/' . $article['category']. '/' . $article['slug']
                    )
                ),
                'content' => $article
            );

            return new Response(json_encode($response), 201);
        });

        $controllers->put('/articles/{category}/{slug}', function(Request $req) use ($app) {
            $db = $app['db'];

            $service = new ArticleProvider();
            $item = $service->get($req, $db);

            $fields = $req->request->all();
            $fields['id'] = $item['id_article'];

            $service = new ArticleEditor();
            $article = $service->update($fields, $db);

            $url = $app['host'] . '/index.php';

            $response = array(
                'links' => array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/articles/' . $article['category'] . '/' . $article['slug']
                    )
                ),
                'article' => $article
            );

            return json_encode($response);
        })
        ->assert('category', '[a-z0-9-]+')
        ->assert('slug', '[a-z0-9-]+');

        $controllers->delete('/articles/{category}/{slug}', function(Request $req) use ($app) {
            $service = new ArticleProvider();

            $item = $service->get($req, $app['db']);

            $id = $item['id_article'];

            try {
                $service = new ArticleRemover();
                $service->delete($id, $app['db']);

                return new Response(json_encode(''), 204);
            } catch(SquarezoneException $e) {
                return new Response(json_encode(''), 404);
            }
        })
        ->assert('category', '[a-z0-9-]+')
        ->assert('slug', '[a-z0-9-]+');


        return $controllers;
    }
}
