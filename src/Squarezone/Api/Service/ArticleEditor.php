<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;

use Squarezone\Exception\SquarezoneException;

class ArticleEditor
{
    public function update($fields, Connection $db)
    {
        if (empty($fields['title'])) {
            throw new SquarezoneException('Missing title', 400);
        }

        $db->update('article', $fields, array('id_article' => $fields['id_article']));

        $sql = 'SELECT a.*, ac.slug AS category 
                FROM article a 
                LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) 
                WHERE id_article = ?';
        
        $article = $db->fetchAssoc($sql, array((int) $fields['id_article']));

        return $article;
    }
}
