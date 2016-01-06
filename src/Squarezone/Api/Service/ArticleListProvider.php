<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;

class ArticleListProvider
{
    public function get(Request $req, Connection $db)
    {
        $category = $req->get('category', false);

        $sql = 'SELECT a.id_article, a.title, a.slug, a.creation_date, ac.slug AS category 
                FROM article a 
                LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category)';

        $whereParts = [];

        if ($category) {
            $whereParts[] = sprintf('ac.slug="%s"', $category);

            $sql .= ' WHERE ' . implode(' AND ', $whereParts);
        } else {
            $sql .= ' LIMIT 0,25';
        }

        return $db->fetchAll($sql);
    }
}
