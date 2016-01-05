<?php

namespace Squarezone\Api;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Squarezone\Api\Service\NewsListProvider;
use Squarezone\Api\Service\NewsProvider;
use Squarezone\Api\Service\OAuth2Service;
use Symfony\Component\HttpFoundation\Request;

// use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NewsControllerProvider implements ControllerProviderInterface {

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

        $controllers->get('/news', function(Request $req) use ($app) {

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

            $service = new NewsListProvider();

            $items = $service->get($req, $app['db']);

            $url = $app['host'] . '/index.php';

            foreach ($items as &$item) {
                $item['links'] = array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/news/'.str_replace('-', '/', substr($item['creation_date'], 0, 10)).'/'.$item['slug']
                    )
                );
            }

            $api = array(
                'content' => $items
            );

            return json_encode($api);
        });

        $controllers->get('/news/{id}', function($id) use ($app){
            $sql = "SELECT * FROM news WHERE id_news = ?";
            $post = $app['db']->fetchAssoc($sql, array((int) $id));

            $url = $app['host'] . '/index.php';

            $api = array(
                'news' => $post
            );

            return json_encode($api);
        })->assert('id', '\d+');


        $controllers->post('/news', function(Request $req) use ($app) {
            // TODO: try to write tests and create separate service for creating news

            $token = $req->get('token', false);

            if ($token !== self::TOKEN) {
                throw new \Exception("Invalid token", 403);
            }

            /** @var Connection $db */
            $db = $app['db'];

            $fields = $req->request->all();

            // create slug

            if (empty($req->get('title'))) {
                throw new \Exception('Missing title', 400);
            }

            $db->insert('news', $fields);

            $lastId = $db->lastInsertId();

            $sql = "SELECT * FROM news WHERE id_news = ?";
            $news = $db->fetchAssoc($sql, array((int) $lastId));

            $url = $app['host'] . '/index.php';

            $api = array(
                'content' => $news
            );

            return json_encode($api);
        });

        return $controllers;
    }
}
