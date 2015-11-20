<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

class ArticleListProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\ArticleListProvider');
    }

    function it_provides_article_list(Request $request, Connection $db)
    {
        $request->get('category', false)->willReturn(false);

        $db->fetchAll('SELECT a.id_article, a.title, a.slug, a.creation_date, ac.slug AS category FROM article a LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) LIMIT 0,25')->willReturn(range(1, 15));

        $this->get($request, $db)->shouldHaveCount(15);
    }

    function it_provides_article_list_for_specific_category(Request $request, Connection $db)
    {
        $request->get('category', false)->willReturn('test');

        $db->fetchAll('SELECT a.id_article, a.title, a.slug, a.creation_date, ac.slug AS category FROM article a LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) WHERE ac.slug="test"')->willReturn(range(1, 15));

        $this->get($request, $db)->shouldHaveCount(15);
    }
}
