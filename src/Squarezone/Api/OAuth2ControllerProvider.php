<?php

namespace Squarezone\Api;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Squarezone\Api\Service\OAuth2Service;

// use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OAuth2ControllerProvider implements ControllerProviderInterface {

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

        $controllers->post('/', function(Request $req) use ($app) {
            $client_id = $req->request->get('client_id');
            $secret = $req->request->get('secret');

            $service = new OAuth2Service($app['db']);

            try {
                $access_token = $service->getAccessToken($client_id, $secret);

                return json_encode($access_token);
            } catch (MissingDataException $e) {
                throw HttpException(400);
            } catch (MissingClientException $e) {
                throw HttpException(404);
            }
        });

        return $controllers;
    }
}
