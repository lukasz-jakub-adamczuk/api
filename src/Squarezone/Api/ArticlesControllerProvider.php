<?php

namespace Squarezone\Api;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

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

        // TODO: Implement connect() method.
        $controllers->get('/articles', function() use ($app) {
            $articles = $app['db']->fetchAll('SELECT id_article, title, slug, creation_date FROM article LIMIT 0,30');

            $url = $app['host'] . '/index.php';

            $api = array(
                'links' => array(
                    array(
                        'rel' => 'next',
                        'href' => $url . '/articles?page=1&size=30'
                    ),
                    // array(
                    // 	'rel' => 'self',
                    // 	'href' => $url . '/news{?page,size,sort}'
                    // )
                ),
                'content' => $articles,
                'page' => array(
                    'size' => 30,
                    'totalElements' => '???',
                    'totalPages' => '???',
                    'number' => 0
                )
            );

            return json_encode($api);
        });

        $controllers->get('/articles/{id}', function($id) use ($app){
            $sql = "SELECT * FROM article WHERE id_article = ?";
            //$sql = "SELECT id_news, title, slug FROM news WHERE id_news = ?";
            $post = $app['db']->fetchAssoc($sql, array((int) $id));

            // return  "<h1>{$post['title']}</h1>".
                    // "<div>{$post['markup']}</div>";
            $url = $app['host'] . '/index.php';

            $api = array(
                'links' => array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/articles/' . $id
                    )
                ),
                'articles' => $post
            );

            return json_encode($api);
        })->assert('id', '\d+');

        // create new article
        $controllers->post('/article', function() use ($app) {
            
            $url = $app['host'] . '/index.php';

            $api = array(
                'links' => array(
                    array(
                        'rel' => 'next',
                        'href' => $url . '/news?page=1&size=30'
                    )
                ),
                'content' => '$article'
            );

            return json_encode($api);
        });

        return $controllers;
    }
}