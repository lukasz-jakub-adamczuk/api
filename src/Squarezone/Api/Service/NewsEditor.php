<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;

use Squarezone\Exception\SquarezoneException;

class NewsEditor
{
    /**
     * @var NewsProvider
     */
    private $provider;

    /**
     * @var Connection
     */
    private $db;

    public function __construct(NewsProvider $provider, Connection $db)
    {
        $this->provider = $provider;
        $this->db = $db;
    }

    public function update(array $newsData, array $fields)
    {
        $item = $this->provider->get($newsData, $this->db);

        // $fields['id_news'] = $item['id_news'];

        if (empty($fields['title'])) {
            throw new SquarezoneException('Missing title', 400);
        }

        $this->db->update('news', $fields, array('id_news' => $item['id_news']));

        $sql = 'SELECT *
                FROM news n
                WHERE id_news = ?';
        
        $news = $this->db->fetchAssoc($sql, array((int) $item['id_news']));

        return $news;
    }
}
