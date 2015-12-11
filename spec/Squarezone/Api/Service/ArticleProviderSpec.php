<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

use Squarezone\Exception\SquarezoneException;

class ArticleProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\ArticleProvider');
    }

    function it_provides_article(Request $request, Connection $db)
    {
    	$request->get('category', false)->willReturn('crono-trigger');
    	$request->get('slug', false)->willReturn('recenzja');

        $db->fetchAssoc('SELECT a.*, ac.slug AS category FROM article a LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) WHERE ac.slug="crono-trigger" AND a.slug="recenzja"')->willReturn(array('title' => '', 'slug' => ''));

        $article = $this->get($request, $db);

        $article->shouldHaveKey('title');
        $article->shouldHaveKey('slug');
    }

    function it_throws_exception_when_params_incorrect(Request $request, Connection $db)
    {
    	$request->get('category', false)->willReturn(false);
    	$request->get('slug', false)->willReturn(false);

    	$db->fetchAssoc(Argument::type('string'))->shouldNotBeCalled();

    	$this->shouldThrow(SquarezoneException::class)->during('get', array($request, $db));
    }

    function it_returns_empty_array_when_article_does_not_exists(Request $request, Connection $db)
    {
    	$request->get('category', false)->willReturn('aaa');
    	$request->get('slug', false)->willReturn('bbb');

        $db->fetchAssoc('SELECT a.*, ac.slug AS category FROM article a LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) WHERE ac.slug="aaa" AND a.slug="bbb"')->willReturn(false);

        $this->get($request, $db)->shouldBe(false);
    }
}
