<?php

namespace Squarezone\Api;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ArticlesCategoriesControllerProvider implements ControllerProviderInterface {

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

        $controllers->get('/articles-categories', function(Request $req) use ($app) {
            $sql = 'SELECT id_article_category, name, slug FROM article_category';

            if ($sql) {
                $items = $app['db']->fetchAll($sql);


                $url = $app['host'] . '/index.php';

                // foreach ($items as &$item) {
                //     $item['links'] = array(
                //         array(
                //             'rel' => 'self',
                //             'href' => $url . '/items/'.str_replace('-', '/', substr($item['creation_date'], 0, 10)).'/'.$item['slug']
                //         )
                //     );
                // }

                $api = array(
                    'links' => array(
                        array(
                            'rel' => 'next',
                            'href' => $url . '/articles-categories?page=1&size=25'
                        ),
                        // array(
                        // 	'rel' => 'self',
                        // 	'href' => $url . '/items{?page,size,sort}'
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
            }
        });

        $controllers->get('/news/{id}', function($id) use ($app){
            $sql = "SELECT * FROM news WHERE id_news = ?";
            $post = $app['db']->fetchAssoc($sql, array((int) $id));

            $url = $app['host'] . '/index.php';

            $api = array(
                'links' => array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/news/' . $id
                    )
                ),
                'news' => $post
            );

            return json_encode($api);
        })->assert('id', '\d+');


        $controllers->post('/articles-categories', function(Request $req) use ($app) {
            $token = $req->get('token', false);

            if ($token !== self::TOKEN) {
                throw new \Exception("Invalid token", 403);
            }

            /** @var Connection $db */
            $db = $app['db'];

            $fields = $req->request->all();

            // create slug

            if (empty($req->get('name'))) {
                throw new \Exception('Missing name', 400);
            }

            $db->insert('article_category', $fields);

            $last_id = $db->lastInsertId();

            // fetch recent items
            $sql = "SELECT * FROM article_category WHERE id_article_category = ?";
            $items = $db->fetchAssoc($sql, array((int) $last_id));

            $url = $app['host'] . '/index.php';

            $api = array(
                'links' => array(
                    array(
                        'rel' => 'next',
                        'href' => $url . '/articles-categories?page=1&size=30'
                    ),
                    // array(
                    // 	'rel' => 'self',
                    // 	'href' => $url . '/news{?page,size,sort}'
                    // )
                ),
                'content' => $items,
                'page' => array(
                    'size' => 30,
                    'totalElements' => count($items),
                    'totalPages' => '???',
                    'number' => 0
                )
            );

            return json_encode($api);
        });

        return $controllers;
    }
}