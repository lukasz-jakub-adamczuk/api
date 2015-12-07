<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

use Squarezone\Exception\SquarezoneException;

class NewsProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\NewsProvider');
    }

    function it_provides_news(Request $request, Connection $db)
    {
        $request->get('year', false)->willReturn('2004');
        $request->get('month', false)->willReturn('06');
        $request->get('day', false)->willReturn('28');
        $request->get('slug', false)->willReturn('insane-in-the-web-square-zone-is-on-fire');

        $db->fetchAssoc('SELECT n.id_news, n.title, n.slug, n.creation_date FROM news n WHERE YEAR(n.creation_date)="2004" AND MONTH(n.creation_date)="06" AND DAY(n.creation_date)="28" AND n.slug="insane-in-the-web-square-zone-is-on-fire"')->willReturn(array('title' => '', 'slug' => ''));

        $news = $this->get($request, $db);

        $news->shouldHaveKey('title');
        $news->shouldHaveKey('slug');
    }

    function it_throws_exception_when_params_incorrect(Request $request, Connection $db)
    {
        $request->get('year', false)->willReturn(false);
        $request->get('month', false)->willReturn(false);
        $request->get('day', false)->willReturn(false);
        $request->get('slug', false)->willReturn(false);

        $db->fetchAssoc(Argument::type('string'))->shouldNotBeCalled();

        $this->shouldThrow(SquarezoneException::class)->during('get', array($request, $db));
    }

    function it_returns_empty_array_when_news_does_not_exists(Request $request, Connection $db)
    {
        $request->get('year', false)->willReturn('2000');
        $request->get('month', false)->willReturn('01');
        $request->get('day', false)->willReturn('01');
        $request->get('slug', false)->willReturn('it-does-not-exists');

        $db->fetchAssoc('SELECT n.id_news, n.title, n.slug, n.creation_date FROM news n WHERE YEAR(n.creation_date)="2000" AND MONTH(n.creation_date)="01" AND DAY(n.creation_date)="01" AND n.slug="it-does-not-exists"')->willReturn(false);

        $this->get($request, $db)->shouldBe(false);
    }
}
