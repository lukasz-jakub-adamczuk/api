<?php

namespace Squarezone\Api;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Squarezone\Api\Service\ArticleListProvider;
use Squarezone\Api\Service\ArticleProvider;
use Symfony\Component\HttpFoundation\Request;

class ArticlesControllerProvider implements ControllerProviderInterface {

    const SIZE = 25;

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

            $api = array(
                'links' => array(
                    array(
                        'rel' => 'next',
                        'href' => $url . '/news?page=1&size=25'
                    ),
                    // array(
                    //  'rel' => 'self',
                    //  'href' => $url . '/news{?page,size,sort}'
                    // )
                ),
                'content' => $items,
                'page' => array(
                    'size' => 25,
                    'totalElements' => count($items),
                    'totalPages' => '???',
                    'number' => 0
                )
            );

            return json_encode($api);
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

            $api = array(
                $items
            );

            return json_encode($api);

        })->assert('category', '[a-z0-9-]+');

        $controllers->get('/articles/{category}/{slug}', function(Request $req) use ($app){
            $service = new ArticleProvider();

            $item = $service->get($req, $app['db']);

            $url = $app['host'] . '/index.php';

            // 'links' => 

            // ResponseCreation::add('links', );

            // return ResponseCreation::get();

            $api = array(
                'links' => array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/articles/' . $item['category'] . '/' . $item['slug']
                    )
                ),
                'article' => $item
            );

            return json_encode($api);
        })->assert('slug', '[a-z0-9-]+');


        $controllers->post('/news', function(Request $req) use ($app) {
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

            $last_id = $db->lastInsertId();

            

//            $news = $app['db']->('INSERT INTO news VALUE(id_news, title, slug, creation_date');

            $sql = "SELECT * FROM news WHERE id_news = ?";
            $news = $db->fetchAssoc($sql, array((int) $last_id));

            $url = $app['host'] . '/index.php';

            $api = array(
                'links' => array(
                    array(
                        'rel' => 'next',
                        'href' => $url . '/news?page=1&size=30'
                    ),
                    // array(
                    //  'rel' => 'self',
                    //  'href' => $url . '/news{?page,size,sort}'
                    // )
                ),
                'content' => $news,
                'page' => array(
                    'size' => 30,
                    'totalElements' => '???',
                    'totalPages' => '???',
                    'number' => 0
                )
            );

            return json_encode($api);
        });

        return $controllers;
    }
}
