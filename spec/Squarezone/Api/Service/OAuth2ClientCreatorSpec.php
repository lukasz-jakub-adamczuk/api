<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
// use Symfony\Component\HttpFoundation\Request;

// use Squarezone\Exception\SquarezoneException;
use Squarezone\Exception\OAuth2\DuplicatedClientException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class OAuth2ClientCreatorSpec extends ObjectBehavior
{
    // function let(Connection $db)
    // {
    //     $this->beConstructedWith($db);
    // }

    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\OAuth2ClientCreator');
    }

    function it_throws_exception_when_client_exists($name, Connection $db)
    {
        // $db->fetchAssoc('SELECT created_at FROM oauth_access_token WHERE access_token = ?', array('999999'))->willThrow(UniqueConstraintViolationException::class);

        $secret = sha1('very-secret-key');

        $fields = ['client_id' => '999999', 'secret' => $secret];

        $db->insert('oauth_clients', $fields)->willThrow(UniqueConstraintViolationException::class);

        $this->shouldThrow(DuplicatedClientException::class)->during('create', array('999999', $db));
    }

    function it_returns_client_id_and_secret($name, Connection $db)
    {
        // $db->fetchAssoc('SELECT created_at FROM oauth_access_token WHERE access_token = ?', array('123456'))->willReturn(array('created_at' => date('Y-m-d H:i:s', time() - 360)));

        $this->create('123456', $db)->shouldHaveKey('client_id');
        // ['client_id' => '123456', 'secret' => 'abc']);
    }
}
