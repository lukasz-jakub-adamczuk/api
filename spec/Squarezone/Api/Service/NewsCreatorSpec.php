<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Squarezone\Exception\SquarezoneException;

class NewsCreatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\NewsCreator');
    }

    function it_creates_news(Connection $db) {
        $fields = ['title' => 'Potencjalny news'];
        
        $db->insert('news', Argument::type('array'))->shouldBeCalled();
        $db->lastInsertId()->willReturn(123);

        $sql = 'SELECT n.id_news, n.title, n.slug, n.creation_date
                FROM news n 
                WHERE id_news = ?';

        $db->fetchAssoc($sql, ['123'])->willReturn(['title' => 'Jakis news']);

        $response = $this->create($fields, $db);

        $response->shouldHaveKey('title');
    }

    function it_throws_exception_when_title_is_missing(Connection $db) {
        $this->shouldThrow(SquarezoneException::class)->during('create', [[], $db]);
    }
}
