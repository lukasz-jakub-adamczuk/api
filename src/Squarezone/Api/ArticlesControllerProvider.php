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

            /** @var Connection $db */
            $db = $app['db'];

            $fields = $req->request->all();

            // create slug

            if (empty($req->get('title'))) {
                throw new \Exception('Missing title', 400);
            }

            $db->insert('article', $fields);

            $last_id = $db->lastInsertId();

            $sql = 'SELECT a.*, ac.slug AS category FROM article a LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) WHERE id_article = ?';
            $article = $db->fetchAssoc($sql, array((int) $last_id));

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

            return json_encode($response);
        });

        $controllers->post('/articles/{category}/{slug}', function(Request $req) use ($app) {
            $db = $app['db'];

            $service = new ArticleProvider();

            $item = $service->get($req, $db);

            $id = $item['id_article'];

            // fields for new
            $fields = $req->request->all();

            $db->update('article', $fields, array('id_article' => $id));

            $sql = 'SELECT a.*, ac.slug AS category FROM article a LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) WHERE id_article = ?';
            $article = $db->fetchAssoc($sql, array((int) $id));

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

        return $controllers;
    }
}
