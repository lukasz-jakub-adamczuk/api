<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;

use Squarezone\Exception\SquarezoneException;

class NewsEditor
{
    public function update($fields, Connection $db)
    {
        if (empty($fields['title'])) {
            throw new SquarezoneException('Missing title', 400);
        }

        $db->update('news', $fields, array('id_news' => $fields['id_news']));

        $sql = 'SELECT *
                FROM news n
                WHERE id_news = ?';
        
        $news = $db->fetchAssoc($sql, array((int) $fields['id_news']));

        return $news;
    }
}
