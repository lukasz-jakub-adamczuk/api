<?php

namespace Squarezone\Api;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

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

            if (!$client_id || !$secret) {
                throw new HttpException(400);
            } else {
                $db = $app['db'];

                $sql = "SELECT id FROM oauth_clients WHERE client_id = ?";
                $client = $db->fetchAssoc($sql, array((string) $client_id));

                print_r($client);

                if (!$client) {
                    throw new HttpException(404);
                } else {
                    // uniqueid()

                    $access_token = sha1(time()+'nfjsahfxnc,mxznfzkehf,vb6548264');
                    $fields = array(
                        'client_id' => $client['id'],
                        'access_token' => $access_token,
                        'created_at' => time()
                    );

                    $db->insert('oauth_access_token', $fields);

                    // $last_id = $db->lastInsertId();

                    // if ($last_id) {

                    // }

                    // $client = $app['db']->('INSERT INTO oauth_access_token VALUE(id, access_token, refresh_token, created_at');

                    $url = $app['host'] . '/index.php';

                    $api = array(
                        'access_token' => $access_token,
                        'expires_at' => 3600
                    );

                    return json_encode($api);
                }

            }
        });

        return $controllers;
    }
}
