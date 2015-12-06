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

            /*if (!$client_id || !$secret) {
                throw new HttpException(400);
            } else {
                $db = $app['db'];

                $sql = 'SELECT id FROM oauth_clients WHERE client_id = ?';
                $client = $db->fetchAssoc($sql, array((string) $client_id));

                if (!$client) {
                    throw new HttpException(404);
                } else {
                    $access_token = sha1(time()+'nfjsahfxnc,mxznfzkehf,vb6548264');
                    $fields = array(
                        'client_id' => $client['id'],
                        'access_token' => $access_token,
                        'created_at' => time()
                    );

                    $db->insert('oauth_access_token', $fields);

                    $api = array(
                        'access_token' => $access_token,
                        'expires_at' => 3600
                    );

                    return json_encode($api);
                }
            }*/
        });

        return $controllers;
    }
}
