<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;

class ArticleListProvider
{
    public function get(Request $req, Connection $db)
    {
        $year = $req->get('year', false);
        $month = $req->get('month', false);
        $day = $req->get('day', false);
        $slug = $req->get('slug', false);

        $sql = 'SELECT id_news, title, slug, creation_date FROM news';

        $whereParts = [];

        if ($year) {
            $whereParts[] = sprintf('YEAR(creation_date)="%s"', $year);
            if ($month) {
                $whereParts[] = sprintf('MONTH(creation_date)="%s"', $month);
                if ($day && $slug) {
                    $whereParts[] = sprintf('DAY(creation_date)="%s"', $month);
                    $whereParts[] = sprintf('slug="%s"', $slug);
                }
            }

            $sql .= ' WHERE ' . implode(' && ', $whereParts);
        } else {
            $sql .= ' LIMIT 0,25';
        }

        return $db->fetchAll($sql);
    }
}
