<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

class NewsListProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\NewsListProvider');
    }

    function it_provides_news_list(Request $request, Connection $db)
    {
        $this->mockRequest($request, false, false, false, false, 1, 25);

        $db->fetchAll('SELECT id_news, title, slug, creation_date FROM news LIMIT 0,25')->willReturn(range(1, 15));

        $this->get($request, $db)->shouldHaveCount(15);
    }

    private function mockRequest(Request $request, $year, $month = false, $day = false, $slug = false, $page = false, $size = false)
    {
        $request->get('year', false)->willReturn($year);
        $request->get('month', false)->willReturn($month);
        $request->get('day', false)->willReturn($day);
        $request->get('slug', false)->willReturn($slug);

        $request->get('page', 1)->willReturn($page);
        $request->get('size', 25)->willReturn($size);
    }

    function it_provides_news_list_for_specific_year(Request $request, Connection $db)
    {
        $this->mockRequest($request, '2015');

        $db->fetchAll('SELECT id_news, title, slug, creation_date FROM news WHERE YEAR(creation_date)="2015"')->willReturn(range(1, 15));

        $this->get($request, $db)->shouldHaveCount(15);
    }

    function it_provides_news_list_for_specific_year_and_month(Request $request, Connection $db)
    {
        $this->mockRequest($request, '2015', '01');

        $db->fetchAll('SELECT id_news, title, slug, creation_date FROM news WHERE YEAR(creation_date)="2015" AND MONTH(creation_date)="01"')->willReturn(range(1, 15));

        $this->get($request, $db)->shouldHaveCount(15);
    }

    function it_provides_news_list_for_specific_year_month_day_and_slug(Request $request, Connection $db)
    {
        $this->mockRequest($request, '2015', '01', '01', 'test');

        $db->fetchAll('SELECT id_news, title, slug, creation_date FROM news WHERE YEAR(creation_date)="2015" AND MONTH(creation_date)="01" AND DAY(creation_date)="01" AND slug="test"')->willReturn(range(1, 15));

        $this->get($request, $db)->shouldHaveCount(15);
    }
}
