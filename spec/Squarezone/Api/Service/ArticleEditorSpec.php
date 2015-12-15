<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Squarezone\Exception\SquarezoneException;

class ArticleEditorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\ArticleEditor');
    }

    function it_updates_article(Connection $db)
    {
        $fields = array('id' => '123', 'title' => 'do zmiany');

        $db->update('article', $fields, array('id_article' => $fields['id']))->shouldBeCalled();

        $db->fetchAssoc('SELECT a.*, ac.slug AS category FROM article a LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) WHERE id_article = ?', array('123'))->willReturn(array('title' => 'do zmiany'));
        
        $response = $this->update($fields, $db);

        $response->shouldHaveKey('title');  
    }

    function it_throws_exception_when_title_is_missing(Connection $db)
    {
        $this->shouldThrow(SquarezoneException::class)->during('update', array(array(), $db));
    }
}
