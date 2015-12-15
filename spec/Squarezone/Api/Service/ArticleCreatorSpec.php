<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Squarezone\Exception\SquarezoneException;

class ArticleCreatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\ArticleCreator');
    }

    function it_creates_article(Connection $db) {
        $fields = array('title' => 'Potencjalny artykul');
        
        $db->insert('article', Argument::type('array'))->shouldBeCalled();
        $db->lastInsertId()->willReturn(123);

        $db->fetchAssoc('SELECT a.*, ac.slug AS category FROM article a LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) WHERE id_article = ?', array('123'))->willReturn(array('title' => 'Jakis artykul'));

        $response = $this->create($fields, $db);

        $response->shouldHaveKey('title');
    }

    function it_throws_exception_when_title_is_missing(Connection $db) {
        $this->shouldThrow(SquarezoneException::class)->during('create', array(array(), $db));
    }
}
