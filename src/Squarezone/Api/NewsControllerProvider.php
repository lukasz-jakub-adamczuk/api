<?php

namespace Squarezone\Api;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

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

        // TODO: Implement connect() method.
        $controllers->get('/news', function() use ($app) {
            // $news = $app['db']->fetchAll('SELECT * FROM news LIMIT 0,30');
            $news = $app['db']->fetchAll('SELECT id_news, title, slug, creation_date FROM news LIMIT 0,30');

            $html = '';
            foreach ($news as $item) {
                // $html .= '<p><a href="./news/'.$item['id_news'].'">' . $item['title'] . '</a></p>';
            }

            // return "<h1>Strona ostatnich newsow</h1>" . $html;

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

        $controllers->get('/news/{id}', function($id) use ($app){
            $sql = "SELECT * FROM news WHERE id_news = ?";
            //$sql = "SELECT id_news, title, slug FROM news WHERE id_news = ?";
            $post = $app['db']->fetchAssoc($sql, array((int) $id));

            // return  "<h1>{$post['title']}</h1>".
                    // "<div>{$post['markup']}</div>";
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


        $controllers->post('/news', function() use ($app) {
            // $news = $app['db']->fetchAll('SELECT * FROM news LIMIT 0,30');
            $news = $app['db']->fetchAll('SELECT id_news, title, slug, creation_date FROM news LIMIT 0,30');

            $html = '';
            foreach ($news as $item) {
                // $html .= '<p><a href="./news/'.$item['id_news'].'">' . $item['title'] . '</a></p>';
            }

            // return "<h1>Strona ostatnich newsow</h1>" . $html;

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