<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

use Squarezone\SquarezoneException;
use Squarezone\Exception\OAuth2\MissingDataException;
use Squarezone\Exception\OAuth2\MissingClientException;

class OAuth2ServiceSpec extends ObjectBehavior
{
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

    function it_returns_access_token(Request $request, Connection $db)
    {
        // $request->request->get('client_id', false)->willReturn('abcdef');
        // $request->request->get('secret', false)->willReturn('123456');
        $request->get('client_id', false)->willReturn('abcdef');
        $request->get('secret', false)->willReturn('123456');

        $db->fetchAssoc('SELECT id FROM oauth_clients WHERE client_id="abcdef" AND secret="123456"')->willReturn(array('id' => ''));

        $response = $this->getAccessToken('abcdef', '123456');

        $response = array(
            'access_token' => $access_token,
            'expires_at' => 3600
        );

        $response->shouldHaveKey('access_token');
        $response->shouldHaveKey('expires_at');
    }

// validateToken

    // function it_throws_exception_when_access_token_is_not_valid() {
    //     3 przypadki
    //     pusty access_token => wyjatek
    //     access_token nie istnieje w bazie => wyjatek
    //     access_token istatnije w bazie ale jest niewazny => wyjatek
    // }

    // function it_returns_true_when_access_token_is_valid() {
    //     jesli wszytko ok => true
    // }
}
