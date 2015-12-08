<?php

namespace Squarezone\Api\Service;

use Squarezone\Exception\OAuth2\MissingDataException;
use Squarezone\Exception\OAuth2\MissingClientException;

use Squarezone\Exception\OAuth2\EmptyAccessTokenException;
use Squarezone\Exception\OAuth2\MissingAccessTokenException;
use Squarezone\Exception\OAuth2\ExpiredAccessTokenException;

class OAuth2Service
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAccessToken($client_id, $secret)
    {
        if (!$client_id || !$secret) {
            throw new MissingDataException();
        } else {
            $sql = 'SELECT id FROM oauth_clients WHERE client_id = ? AND secret = ?';
            $client = $this->db->fetchAssoc($sql, array((string) $client_id, (string) $secret));

            if (!$client) {
                throw new MissingClientException();
            } else {
                $access_token = sha1(time()+'nfjsahfxnc,mxznfzkehf,vb6548264');
                $fields = array(
                    'client_id' => $client['id'],
                    'access_token' => $access_token,
                    'created_at' => date('Y-m-d H:i:s')
                );

                $this->db->insert('oauth_access_token', $fields);

                $response = array(
                    'access_token' => $access_token,
                    'expires_at' => 3600
                );

                return $response;
            }
        }
    }

    public function validateAccessToken($access_token) {

        if (!$access_token) {
            throw new EmptyAccessTokenException();
        } else {
            $sql = 'SELECT created_at FROM oauth_access_token WHERE access_token = ?';
            $token = $this->db->fetchAssoc($sql, array($access_token));

            if (!$token) {
                throw new MissingAccessTokenException();
            } else {
                $period = time() - strtotime($token['created_at']);

                if ($period > 3600) {
                    throw new ExpiredAccessTokenException();
                } else {
                    return true;
                }
            }
        }
    }
}
