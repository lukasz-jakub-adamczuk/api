<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Squarezone\Exception\SquarezoneException;
use Squarezone\Exception\NotFoundException;

class NewsProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\NewsProvider');
    }

    function it_provides_news(Connection $db)
    {
        $newsData = [
            'year' => '2004',
            'month' => '06',
            'day' => '28',
            'slug' => 'insane-in-the-web-square-zone-is-on-fire'
        ];

        $db->fetchAssoc('SELECT n.id_news, n.title, n.slug, n.creation_date FROM news n WHERE YEAR(n.creation_date)="2004" AND MONTH(n.creation_date)="06" AND DAY(n.creation_date)="28" AND n.slug="insane-in-the-web-square-zone-is-on-fire"')->willReturn(['title' => '', 'slug' => '']);

        $news = $this->get($newsData, $db);

        $news->shouldHaveKey('title');
        $news->shouldHaveKey('slug');
    }

    function it_throws_exception_when_params_incorrect(Connection $db)
    {
        $newsData = [
            'year' => false,
            'month' => false,
            'day' => false,
            'slug' => false
        ];

        $db->fetchAssoc(Argument::type('string'))->shouldNotBeCalled();

        $this->shouldThrow(SquarezoneException::class)->during('get', [$newsData, $db]);
    }

    function it_throws_exception_news_does_not_exists(Connection $db)
    {
        $newsData = [
            'year' => '2000',
            'month' => '01',
            'day' => '01',
            'slug' => 'it-does-not-exists'
        ];

        $db->fetchAssoc('SELECT n.id_news, n.title, n.slug, n.creation_date FROM news n WHERE YEAR(n.creation_date)="2000" AND MONTH(n.creation_date)="01" AND DAY(n.creation_date)="01" AND n.slug="it-does-not-exists"')->willReturn(false);

        $this->shouldThrow(NotFoundException::class)->during('get', [$newsData, $db]);
    }
}
