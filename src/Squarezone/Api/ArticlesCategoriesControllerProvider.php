<?php

namespace Squarezone\Api;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ArticlesCategoriesControllerProvider implements ControllerProviderInterface
{

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

        $controllers->get('/articles-categories', function (Request $req) use ($app) {
            $sql = 'SELECT id_article_category, name, slug FROM article_category';

            if ($sql) {
                $items = $app['db']->fetchAll($sql);

                $url = $app['host'] . '/index.php';

                $api = [
                    'content' => $items
                ];

                return json_encode($api);
            }
        });

        $controllers->get('/articles-categories/{id}', function ($id) use ($app) {
            $sql = 'SELECT * FROM article_category WHERE id_article_category = ?';
            $post = $app['db']->fetchAssoc($sql, [(int) $id]);

            $url = $app['host'] . '/index.php';

            $api = [
                'links' => [
                    [
                        'rel' => 'self',
                        'href' => $url . '/articles-categories/' . $id
                    ]
                ],
                'articles-categories' => $post
            ];

            return json_encode($api);
        })->assert('id', '\d+');


        $controllers->post('/articles-categories', function (Request $req) use ($app) {
            $token = $req->get('token', false);

            if ($token !== self::TOKEN) {
                throw new \Exception('Invalid token', 403);
            }

            /** @var Connection $db */
            $db = $app['db'];

            $fields = $req->request->all();

            // create slug

            if (empty($req->get('name'))) {
                throw new \Exception('Missing name', 400);
            }

            $db->insert('article_category', $fields);

            $lastId = $db->lastInsertId();

            // fetch recent items
            $sql = 'SELECT * FROM article_category WHERE id_article_category = ?';
            $items = $db->fetchAssoc($sql, [(int) $lastId]);

            $url = $app['host'] . '/index.php';

            $api = [
                'content' => $items
            ];

            return json_encode($api);
        });

        return $controllers;
    }
}
