<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;

use Squarezone\Exception\SquarezoneException;

class ArticleProvider
{
    public function get(Request $req, Connection $db)
    {
        $category = $req->get('category', false);
        $slug = $req->get('slug', false);

        if (empty($category) || empty($slug)) {
            throw new SquarezoneException();
        }

        $sql = 'SELECT a.*, ac.slug AS category 
                FROM article a 
                LEFT JOIN article_category ac ON(ac.id_article_category=a.id_article_category) 
                WHERE ac.slug="%s" AND a.slug="%s"';

        $sql = sprintf($sql, $category, $slug);

        // $whereParts = [];

        // $whereParts[] = sprintf('ac.slug="%s"', $category);
        // $whereParts[] = sprintf('a.slug="%s"', $slug);

        // $sql .= ' WHERE ' . implode(' AND ', $whereParts);

        if ($result = $db->fetchAssoc($sql)) {
            return $result;
        }
        return false;
    }
}
