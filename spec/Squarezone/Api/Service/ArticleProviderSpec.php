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

    function it_provides_article(Request $req, Connection $db)
    {
    	$req->get('category', false)->willReturn('crono-trigger');
    	$req->get('slug', false)->willReturn('recenzja');

        $sql = 'SELECT a.*, ac.slug AS category 
                FROM article a 
                LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) 
                WHERE ac.slug="crono-trigger" AND a.slug="recenzja"';

        $db->fetchAssoc($sql)->willReturn(array('title' => '', 'slug' => ''));

        $article = $this->get($req, $db);

        $article->shouldHaveKey('title');
        $article->shouldHaveKey('slug');
    }

    function it_throws_exception_when_params_incorrect(Request $req, Connection $db)
    {
    	$req->get('category', false)->willReturn(false);
    	$req->get('slug', false)->willReturn(false);

    	$db->fetchAssoc(Argument::type('string'))->shouldNotBeCalled();

    	$this->shouldThrow(SquarezoneException::class)->during('get', array($req, $db));
    }

    function it_returns_empty_array_when_article_does_not_exists(Request $req, Connection $db)
    {
    	$req->get('category', false)->willReturn('aaa');
    	$req->get('slug', false)->willReturn('bbb');

        $sql = 'SELECT a.*, ac.slug AS category 
                FROM article a 
                LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) 
                WHERE ac.slug="aaa" AND a.slug="bbb"';

        $db->fetchAssoc($sql)->willReturn(false);

        $this->get($req, $db)->shouldBe(false);
    }
}
