<?php

namespace Squarezone\Api;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Squarezone\Api\Service\NewsListProvider;
use Squarezone\Api\Service\NewsProvider;
use Squarezone\Api\Service\NewsCreator;
use Squarezone\Api\Service\NewsEditor;
// use Squarezone\Api\Service\NewsRemover;
// use Squarezone\Api\Service\OAuth2Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NewsControllerProvider implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/news', function (Request $req) use ($app) {
            $service = new NewsListProvider();

            $items = $service->get($req, $app['db']);

            $url = $app['host'] . '/index.php';

            foreach ($items as &$item) {
                $path = str_replace('-', '/', substr($item['creation_date'], 0, 10));
                $item['links'] = array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/news/' . $path . '/' . $item['slug']
                    )
                );
            }

            $api = array(
                'content' => $items
            );

            return json_encode($api);
        });

        $controllers->get('/news/{year}/{month}/{day}/{slug}', function (Request $req) use ($app) {
            $service = new NewsProvider();

            $fields = $req->attributes->get('_route_params');
            // $item = $service->get($fields, $app['db']);
            $item = $service->get($fields, $app['db']);
            
            $url = $app['host'] . '/index.php';

            $path = str_replace('-', '/', substr($item['creation_date'], 0, 10));

            $response = array(
                'links' => array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/news/' . $path . '/' . $item['slug']
                    )
                ),
                'news' => $item
            );

            return json_encode($response);
        })
        ->assert('year', '[0-9]{4}+')
        ->assert('month', '[0-9]{1,2}+')
        ->assert('day', '[0-9]{1,2}+')
        ->assert('slug', '[a-z0-9-]+');

        $controllers->post('/news', function (Request $req) use ($app) {
            $service = new NewsCreator();

            $fields = $req->request->all();

            $news = $service->create($fields, $app['db']);

            $url = $app['host'] . '/index.php';

            $path = str_replace('-', '/', substr($news['creation_date'], 0, 10));

            $response = array(
                'links' => array(
                    'rel' => 'self',
                    'href' => $url . '/news/' . $path . '/' . $item['slug']
                ),
                'content' => $news
            );

            return new Response(json_encode($response), 201);
        });

        $controllers->put('/news/{year}/{month}/{day}/{slug}', function (Request $req) use ($app) {
            // $db = $app['db'];

            // $service = new NewsProvider();

            // $fields = $req->query->all();
            // $fields = ['year' => $year, 'month' => $month];
            $newsData = $req->attributes->get('_route_params');
            $fields = $req->request->all();

            try {
                // $item = $service->get($fields, $app['db']);
                $service = new NewsEditor(new NewsProvider(), $app['db']);
                $news = $service->update($newsData, $fields);
            } catch (NotFoundException $e) {
                throw HttpException(404);
            }

            // $fields = $req->request->all();
            // $fields['id_news'] = $item['id_news'];

            // $service = new NewsEditor();
            // $news = $service->update($fields, $db);

            $url = $app['host'] . '/index.php';

            $path = str_replace('-', '/', substr($news['creation_date'], 0, 10));

            $response = array(
                'links' => array(
                    array(
                        'rel' => 'self',
                        'href' => $url . '/news/' . $path . '/' . $news['slug']
                    )
                ),
                'news' => $news
            );

            return json_encode($response);
        })
        ->assert('year', '[0-9]{4}+')
        ->assert('month', '[0-9]{1,2}+')
        ->assert('day', '[0-9]{1,2}+')
        ->assert('slug', '[a-z0-9-]+');

        $controllers->delete('/news/{year}/{month}/{day}/{slug}', function (Request $req) use ($app) {
            $service = new NewsProvider();

            $item = $service->get($req, $app['db']);

            $id = $item['id_news'];

            try {
                $service = new NewsRemover();
                $service->delete($id, $app['db']);

                return new Response(json_encode(''), 204);
            } catch (SquarezoneException $e) {
                return new Response(json_encode(''), 404);
            }
        })
        ->assert('year', '[0-9]{4}+')
        ->assert('month', '[0-9]{1,2}+')
        ->assert('day', '[0-9]{1,2}+')
        ->assert('slug', '[a-z0-9-]+');

        return $controllers;
    }
}
