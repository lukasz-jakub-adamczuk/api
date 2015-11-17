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
        $db->fetchAll('SELECT id_news, title, slug, creation_date FROM news LIMIT 0,25')->willReturn(range(1, 15));

        $this->get($request, $db)->shouldHaveCount(15);
    }

    function it_provides_article_list_for_specific_year(Request $request, Connection $db)
    {
        $request->get('year', false)->willReturn('2015');
        $request->get('month', false)->willReturn(false);
        $request->get('day', false)->willReturn(false);
        $request->get('slug', false)->willReturn(false);

        $db->fetchAll('SELECT id_news, title, slug, creation_date FROM news WHERE YEAR(creation_date)="2015"')->willReturn(range(1, 15));

        $this->get($request, $db)->shouldHaveCount(15);
    }

    function it_provides_article_list_for_specific_year_and_month(Request $request, Connection $db)
    {
        $request->get('year', false)->willReturn('2015');
        $request->get('month', false)->willReturn('01');
        $request->get('day', false)->willReturn(false);
        $request->get('slug', false)->willReturn(false);

        $db->fetchAll('SELECT id_news, title, slug, creation_date FROM news WHERE YEAR(creation_date)="2015" && MONTH(creation_date)="01"')->willReturn(range(1, 15));

        $this->get($request, $db)->shouldHaveCount(15);
    }

    function it_provides_article_list_for_specific_year_month_day_and_slug(Request $request, Connection $db)
    {
        $request->get('year', false)->willReturn('2015');
        $request->get('month', false)->willReturn('01');
        $request->get('day', false)->willReturn('01');
        $request->get('slug', false)->willReturn('test');

        $db->fetchAll('SELECT id_news, title, slug, creation_date FROM news WHERE YEAR(creation_date)="2015" && MONTH(creation_date)="01" && DAY(creation_date)="01" && slug="test"')->willReturn(range(1, 15));

        $this->get($request, $db)->shouldHaveCount(15);
    }
}