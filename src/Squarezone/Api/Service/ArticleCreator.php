<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Squarezone\Exception\SquarezoneException;

class ArticleCreator
{
    public function create(array $fields, Connection $db)
    {
        if (empty($fields['title'])) {
            throw new SquarezoneException('Missing title', 400);
        }

        $db->insert('article', $fields);

        $lastId = $db->lastInsertId();

        $sql = 'SELECT a.*, ac.slug AS category 
                FROM article a 
                LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) 
                WHERE id_article = ?';
        
        $article = $db->fetchAssoc($sql, [(int) $lastId]);

        return $article;
    }
}
