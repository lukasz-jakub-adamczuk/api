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
use Squarezone\Exception\OAuth2\MissingAccessTokenException;
use Squarezone\Exception\OAuth2\ExpiredAccessTokenException;

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
        $this->shouldThrow(MissingDataException::class)->during('getAccessToken', ['', '']);
    }

    function it_throws_exception_when_client_not_exists()
    {
        $this->shouldThrow(MissingClientException::class)->during('getAccessToken', ['aaa', '123']);
    }

    function it_returns_access_token(Connection $db)
    {
        $db->fetchAssoc('SELECT id FROM oauth_clients WHERE client_id = ? AND secret = ?', ['abcdef', '123456'])->willReturn(['id' => '']);

        $db->insert('oauth_access_token', Argument::type('array'))->shouldBeCalled();

        $response = $this->getAccessToken('abcdef', '123456');

        $response->shouldHaveKey('access_token');
        $response->shouldHaveKey('expires_at');
    }

    function it_throws_exception_when_access_token_is_empty()
    {
        $this->shouldThrow(EmptyAccessTokenException::class)->during('isValidAccessToken', ['']);
    }

    function it_throws_exception_when_access_token_does_not_exists()
    {
        $this->shouldThrow(MissingAccessTokenException::class)->during('isValidAccessToken', ['000000']);
    }

    function it_throws_exception_when_access_token_is_expired(Connection $db)
    {
        $db->fetchAssoc('SELECT created_at FROM oauth_access_token WHERE access_token = ?', ['999999'])->willReturn(['created_at' => date('Y-m-d H:i:s', time() - 7200)]);

        $this->shouldThrow(ExpiredAccessTokenException::class)->during('isValidAccessToken', ['999999']);
    }

    function it_returns_true_when_access_token_is_valid(Connection $db)
    {
        $db->fetchAssoc('SELECT created_at FROM oauth_access_token WHERE access_token = ?', ['123456'])->willReturn(['created_at' => date('Y-m-d H:i:s', time() - 360)]);

        $this->isValidAccessToken('123456')->shouldReturn(true);
    }
}
