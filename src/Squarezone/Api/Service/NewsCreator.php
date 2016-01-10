<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Squarezone\Exception\SquarezoneException;

class NewsCreator
{
    public function create(array $fields, Connection $db)
    {
        if (empty($fields['title'])) {
            throw new SquarezoneException('Missing title', 400);
        }

        $db->insert('news', $fields);

        $lastId = $db->lastInsertId();

        $sql = 'SELECT n.id_news, n.title, n.slug, n.creation_date
                FROM news n 
                WHERE id_news = ?';
        
        $news = $db->fetchAssoc($sql, array((int) $lastId));

        return $news;
    }
}
