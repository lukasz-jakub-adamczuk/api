<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Squarezone\Exception\SquarezoneException;

class ArticleRemoverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\ArticleRemover');
    }

    function it_removes_article(Connection $db)
    {
        $db->delete('article', ['123']);

        $this->delete('123', $db);
    }

    function it_throws_exception_when_id_is_not_true(Connection $db)
    {
        $this->shouldThrow(SquarezoneException::class)->during('delete', [false, $db]);
    }
}
