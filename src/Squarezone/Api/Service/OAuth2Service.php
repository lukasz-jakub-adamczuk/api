<?php

namespace Squarezone\Api\Service;

use Squarezone\Exception\OAuth2\MissingDataException;
use Squarezone\Exception\OAuth2\MissingClientException;

use Squarezone\Exception\OAuth2\EmptyAccessTokenException;
use Squarezone\Exception\OAuth2\MissingAccessTokenException;
use Squarezone\Exception\OAuth2\ExpiredAccessTokenException;

class OAuth2Service
{
    const OAUTH_ACCESS_TOKEN_TTL = 3600;

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAccessToken($clientId, $secret)
    {
        if (!$clientId || !$secret) {
            throw new MissingDataException();
        } else {
            $sql = 'SELECT id FROM oauth_clients WHERE client_id = ? AND secret = ?';
            $client = $this->db->fetchAssoc($sql, array((string) $clientId, (string) $secret));

            if (!$client) {
                throw new MissingClientException();
            } else {
                $accessToken = sha1(time()+'nfjsahfxnc,mxznfzkehf,vb6548264');
                $fields = array(
                    'client_id' => $client['id'],
                    'access_token' => $accessToken,
                    'created_at' => date('Y-m-d H:i:s')
                );

                $this->db->insert('oauth_access_token', $fields);

                $response = array(
                    'access_token' => $accessToken,
                    'expires_at' => self::OAUTH_ACCESS_TOKEN_TTL
                );

                return $response;
            }
        }
    }

    public function isValidAccessToken($accessToken)
    {
        if (!$accessToken) {
            throw new EmptyAccessTokenException();
        } else {
            $sql = 'SELECT created_at FROM oauth_access_token WHERE access_token = ?';
            $token = $this->db->fetchAssoc($sql, array($accessToken));

            if (!$token) {
                throw new MissingAccessTokenException();
            } else {
                $period = time() - strtotime($token['created_at']);

                if ($period > self::OAUTH_ACCESS_TOKEN_TTL) {
                    throw new ExpiredAccessTokenException();
                } else {
                    return true;
                }
            }
        }
    }
}
