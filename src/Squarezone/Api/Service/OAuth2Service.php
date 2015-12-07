<?php

namespace Squarezone\Api\Service;

use Squarezone\Exception\OAuth2\MissingDataException;
use Squarezone\Exception\OAuth2\MissingClientException;

class OAuth2Service
{
    // private $db;

    // public function __construct($db) {
    //     $this->db = $db;
    // }

    public function getAccessToken($client_id, $secret)
    {
        if (!$client_id || !$secret) {
            throw new MissingDataException();
        } else {
            $sql = 'SELECT id FROM oauth_clients WHERE client_id = ?';
            $client = $db->fetchAssoc($sql, array((string) $client_id));

            if (!$client) {
                throw new MissingClientException();
            } else {
                $access_token = sha1(time()+'nfjsahfxnc,mxznfzkehf,vb6548264');
                $fields = array(
                    'client_id' => $client['id'],
                    'access_token' => $access_token,
                    'created_at' => time()
                );

                $db->insert('oauth_access_token', $fields);

                $response = array(
                    'access_token' => $access_token,
                    'expires_at' => 3600
                );

                return json_encode($response);
            }
        }
    }

    public function validateAccessToken($access_token) {
        // TODO: write logic here
    }
}
