<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

use Squarezone\Exception\SquarezoneException;
use Squarezone\Exception\OAuth2\MissingDataException;
use Squarezone\Exception\OAuth2\MissingClientException;

use Squarezone\Exception\OAuth2\EmptyAccessTokenException;

class OAuth2ServiceSpec extends ObjectBehavior
{
    function let(Connection $db)
    {
        $this->beConstructedWith($db);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\OAuth2Service');
    }

    function it_throws_exception_when_no_client_id_or_secret()
    {
        $this->shouldThrow(MissingDataException::class)->during('getAccessToken', array('', ''));
    }

    function it_throws_exception_when_client_not_exists()
    {
        $this->shouldThrow(MissingClientException::class)->during('getAccessToken', array('aaa', '123'));
    }

    function it_returns_access_token(Connection $db)
    {
        $db->fetchAssoc('SELECT id FROM oauth_clients WHERE client_id = ? AND secret = ?', array('abcdef', '123456'))->willReturn(array('id' => ''));

        $db->insert('oauth_access_token', Argument::type('array'))->shouldBeCalled();

        $response = $this->getAccessToken('abcdef', '123456');

        $response->shouldHaveKey('access_token');
        $response->shouldHaveKey('expires_at');
    }

    function it_throws_exception_when_access_token_is_empty()
    {
        $this->shouldThrow(EmptyAccessTokenException::class)->during('validateAccessToken', array(''));
    }

    function it_throws_exception_when_access_token_does_not_exists()
    {
        $this->shouldThrow(MissingAccessTokenException::class)->during('validateAccessToken', array('000000'));
    }

    function it_throws_exception_when_access_token_is_expired()
    {
        $this->shouldThrow(ExpiredAccessTokenException::class)->during('validateAccessToken', array('999999'));
    }

    function it_returns_true_when_access_token_is_valid()
    {
        // OK
    }
}
