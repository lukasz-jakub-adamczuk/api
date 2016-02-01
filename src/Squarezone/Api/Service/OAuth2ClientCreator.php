<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Squarezone\Exception\OAuth2\DuplicatedClientException;

class OAuth2ClientCreator
{
    public function create($name, Connection $db)
    {
        try {
            $secret = sha1('very-secret-key');
            // $secret = sha1(time()+'nfjsahfxnc,mxznfzkehf,vb6548264');
            
            $fields = ['client_id' => $name, 'secret' => $secret];

            $db->insert('oauth_clients', $fields);

            return $fields;
        } catch (UniqueConstraintViolationException $e) {
            throw new DuplicatedClientException();
        }
    }
}
