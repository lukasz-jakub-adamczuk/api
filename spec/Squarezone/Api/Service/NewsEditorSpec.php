<?php

namespace spec\Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Squarezone\Api\Service\NewsProvider;

use Squarezone\Exception\SquarezoneException;

class NewsEditorSpec extends ObjectBehavior
{
	function let(NewsProvider $newsProvider, Connection $db)
    {
        $this->beConstructedWith($newsProvider, $db);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Squarezone\Api\Service\NewsEditor');
    }

    function it_updates_news(Connection $db)
    {
    	$newsData = [
            'year' => '2004',
            'month' => '06',
            'day' => '28',
            'slug' => 'insane-in-the-web-square-zone-is-on-fire'
        ];

        $fields = ['id_news' => '123', 'title' => 'do zmiany'];

        $db->update('news', $fields, ['id_news' => $fields['id_news']])->shouldBeCalled();

        $response = $this->update($newsData, $fields);

        $response->shouldHaveKey('title'); 

        $sql = 'SELECT *
                FROM news n 
                WHERE id_news = ?';

        $db->fetchAssoc($sql, ['123'])->willReturn(['title' => 'do zmiany']);
        
        // $response->shouldHaveKey('title');
    }

    function it_throws_exception_when_title_is_missing(Connection $db)
    {
        $this->shouldThrow(SquarezoneException::class)->during('update', [[], []]);
    }
}
