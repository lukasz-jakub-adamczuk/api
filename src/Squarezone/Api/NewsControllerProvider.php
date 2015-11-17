<?php

namespace Squarezone\Api;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class NewsControllerProvider implements ControllerProviderInterface {

    const TOKEN = 'abc123';

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
            // TODO: refactor
            $year = $req->get('year', false);
            $month = $req->get('month', false);
            $day = $req->get('day', false);
            $slug = $req->get('slug', false);

            if ($year) {
                $sql = 'SELECT id_news, title, slug, creation_date FROM news WHERE YEAR(creation_date)="'.$year.'"';
                if ($month) {
                    $sql = 'SELECT id_news, title, slug, creation_date FROM news WHERE YEAR(creation_date)="'.$year.'" && MONTH(creation_date)="'.$month.'"';
                    if ($day && $slug) {
                        $sql = 'SELECT id_news, title, slug, creation_date FROM news WHERE YEAR(creation_date)="'.$year.'" && MONTH(creation_date)="'.$month.'" && DAY(creation_date)="'.$day.'" && slug="'.$slug.'"';
                    }
                }
            } else {
                $sql = 'SELECT id_news, title, slug, creation_date FROM news LIMIT 0,25';
            }

            if ($sql) {
                $news = $app['db']->fetchAll($sql);


                $url = $app['host'] . '/index.php';

                foreach ($news as &$item) {
                    $item['links'] = array(
                        array(
                            'rel' => 'self',
                            'href' => $url . '/news/'.str_replace('-', '/', substr($item['creation_date'], 0, 10)).'/'.$item['slug']
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
                        // 	'rel' => 'self',
                        // 	'href' => $url . '/news{?page,size,sort}'
                        // )
                    ),
                    'content' => $news,
                    'page' => array(
                        'size' => 25,
                        'totalElements' => count($news),
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
                    // 	'rel' => 'self',
                    // 	'href' => $url . '/news{?page,size,sort}'
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
