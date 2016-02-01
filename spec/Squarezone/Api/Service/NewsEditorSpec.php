<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Squarezone\Api\Service\NewsProvider;

use Squarezone\Exception\SquarezoneException;

class NewsEditorSpec extends ObjectBehavior
{
	function let(NewsProvider $newsProvider)
    {
        $this->beConstructedWith($newsProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\NewsEditor');
    }

    function it_updates_news(Connection $db)
    {
        $fields = array('id' => '123', 'title' => 'do zmiany');

        $db->update('news', $fields, array('id_news' => $fields['id']))->shouldBeCalled();

        $sql = 'SELECT *
                FROM news n 
                WHERE id_news = ?';

        $db->fetchAssoc($sql, array('123'))->willReturn(array('title' => 'do zmiany'));
        
        $response = $this->update($fields, $db);

        $response->shouldHaveKey('title');  
    }

    function it_throws_exception_when_title_is_missing(Connection $db)
    {
        $this->shouldThrow(SquarezoneException::class)->during('update', array(array(), $db));
    }
}
