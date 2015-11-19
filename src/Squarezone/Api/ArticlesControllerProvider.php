<?php

namespace Squarezone\Api;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Squarezone\Api\Service\ArticleListProvider;
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
            $category = $req->get('category', false);

            if ($category) {
                $sql = 'SELECT a.id_article, a.title, a.slug, a.creation_date FROM article a LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) WHERE ac.slug="'.$category.'"';
            }

            $page = $req->get('page', 1);
            $size = $req->get('size', self::SIZE);

            if ($page) {
                $sql .= ' LIMIT ' . (($page-1)*$size) . ',' . ($page*$size);
            }

            if ($sql) {
                $items = $app['db']->fetchAll($sql);

                $url = $app['host'] . '/index.php';

                foreach ($items as &$item) {
                    $item['links'] = array(
                        array(
                            'rel' => 'self',
                            'href' => $url . '/articles/'.$category.'/'.$item['slug']
                        )
                    );
                }

                $api = array(
                    'links' => array(
                        array(
                            'rel' => 'next',
                            'href' => $url . '/articles?page=1&size=25'
                        ),
                        // array(
                        //  'rel' => 'self',
                        //  'href' => $url . '/news{?page,size,sort}'
                        // )
                    ),
                    'content' => $items,
                    'page' => array(
                        'size' => $size,
                        'totalElements' => count($items),
                        'totalPages' => '???',
                        'number' => $page
                    )
                );

                return json_encode($api);
            }
        })->assert('slug', '\w+');

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
        })->assert('id', '[a-z-]+');


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
