<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
// use Symfony\Component\HttpFoundation\Request;

use Squarezone\Exception\SquarezoneException;

class ArticleCreatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\ArticleCreator');
    }

    function it_creates_article(Connection $db) {
    	// $fields['title']->shouldBe('Potencjalny artykul');
    	// $this->fields->shouldBeArray();
    	$fields = array('title' => 'Potencjalny artykul');

    	$db->fetchAssoc('SELECT id FROM oauth_clients WHERE client_id = ? AND secret = ?', array('abcdef', '123456'))->willReturn(array('id' => ''));

        $db->insert('article', Argument::type('array'))->shouldBeCalled();

        $response = $this->create($fields, $db);

        $response->shouldHaveKey('title');
    }

    function it_throws_exception_when_title_is_missing(Connection $db) {
    	$this->shouldThrow(SquarezoneException::class)->during('create', array(array(), $db));
    }
}
